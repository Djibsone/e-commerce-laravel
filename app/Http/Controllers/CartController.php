<?php

namespace App\Http\Controllers;

use App\Http\Requests\cartRequest;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function store(cartRequest $request)
    {
        $ValidatedData = $request->validated();

        $duplicate = Cart::search(function ($cartItem, $rowId) use ($ValidatedData) {
            return $cartItem->id == $ValidatedData['product_id'];
        });

        if ($duplicate->isNotEmpty()) {
            return to_route('product.index')->with('success', 'Le produit a déjà été ajouté.');
        }

        $product = Product::FindOrFail($ValidatedData['product_id']);

        // dd($product->title, $ValidatedData['quantity'], $product->price);

        Cart::add($ValidatedData['product_id'], $product->title, /*$ValidatedData['quantity'] */ 1, $product->price)->associate(Product::class);

        return to_route('product.index')->with('success', 'Le produit a bien été ajouté.');
    }

    // public function update(Request $request, $rowId) {
    //     $data = $request->json()->all();

    //     Cart::update($rowId, $data['qty']);

    //     Session::flash('success', 'La quantité du produit est passée à ' . $data['qty'] . '.');

    //     return response()->json(['success' => 'Cart Quantity Has Been Updated']);
    // }

    public function update(Request $request, $rowId)
    {
        $data = $request->json()->all();

        if ($data['qty'] > $data['stock']) {
            return response()->json(['success' => 'Product Quantity Has Been Available.']);
        }
        $cart = Cart::update($rowId, $data['qty']);

        // Si nécessaire, faites d'autres manipulations ou traitements avec le panier ici.

        return response()->json(['success' => 'Cart Quantity Has Been Updated.']);
    }

    public function destroy($rowId)
    {
        Cart::remove($rowId);

        return back()->with('success', 'Le produit a été supprimé.');
    }
}
