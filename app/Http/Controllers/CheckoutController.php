<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index()
    {
        if (Cart::count() <= 0) {
            return to_route('product.index');
        }

        Stripe::setApiKey('sk_test_VePHdqKTYQjKNInc7u56JBrQ');

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'xof',
        ]);

        $clientSecret = Arr::get($intent, 'client_secret');

        return view('checkout.index', [
            'clientSecret' => $clientSecret,
        ]);
    }

    public function store(Request $request)
    {
        if ($this->checkIfNotAvailable()) {
            Session::flash('error', 'Un produit dans votre paier n\'est plus disponible.');
            return response()->json(['success' => false], 400);
        }

        $data = $request->json()->all();

        $products = [];
        $i = 0;

        foreach (Cart::content() as $product) {
            $products['product_' . $i][] = $product->model->title;
            $products['product_' . $i][] = $product->model->price;
            $products['product_' . $i][] = $product->qty;
            $i++;
        }

        Order::create([
            $data['paymentIntent']['id'],
            $data['paymentIntent']['amount'],
            (new DateTime())
                ->setTimestamp($data['paymentIntent']['create'])
                ->format('Y-m-d H:i:s'),
            serialize($products),
            ($user_id = 1),
        ]);

        if ($data['paymentIntent']['status'] === 'succeeded') {
            $this->updateStock();
            Cart::destroy();
            Session::flash('success', 'Votre commande a été traitée avec succès.');
            return response()->json(['success' => 'Payment Intent Succeeded']);
        } else {
            return response()->json(['success' => 'Payment Intent Not Succeeded']);
        }
    }

    public function thankyou()
    {
        return Session::has('success') ? view('checkout.thankyou') : to_route('product.index');
    }

    private function checkIfNotAvailable()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);

            if ($product->stock < $item->qty) {
                return true;
            }
        }

        return false;
    }

    private function updateStock()
    {
        foreach (Cart::content() as $item) {
            $product = Product::find($item->model->id);
            $product->update(['stock' => $product->stock - $item->qty]);
        }
    }
}
