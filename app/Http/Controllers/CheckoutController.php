<?php

namespace App\Http\Controllers;

use App\Models\Order;
use DateTime;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class CheckoutController extends Controller
{
    public function index() {

        if (Cart::count() <= 0) {
           return to_route('product.index');
        }

        Stripe::setApiKey('');

        $intent = PaymentIntent::create([
            'amount' => round(Cart::total()),
            'currency' => 'xof',
        ]);
    
        $clientSecret = Arr::get($intent, 'client_secret');

        return view('checkout.index', [
            'clientSecret' => $clientSecret
        ]);
    }

    public function store(Request $request) {
        
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
            (new DateTime())->setTimestamp($data['paymentIntent']['create'])->format('Y-m-d H:i:s'),
            serialize($products),
            $user_id = 1
        ]);

        if ($data['paymentIntent']['status'] === 'succeeded') {
            Cart::destroy();
            Session::flash('success', 'Votre commande a été traitée avec succès.');
            return response()->json(['success' => 'Payment Intent Succeeded']);
        } else {
            return response()->json(['success' => 'Payment Intent Not Succeeded']);
        }        
    }

    public function thankyou() {
        return Session::has('success') ? view('checkout.thankyou') : to_route('product.index');
    }
}
