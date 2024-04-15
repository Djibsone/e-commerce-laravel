<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index() {

        if (request()->categorie) {
            $products = Product::with('categories')->whereHas('categories', function($query) {
                $query->where('slug', request()->categorie);
            })->orderBy('id', 'desc')->paginate(10);
        } else {
            $products = Product::with('categories')->orderBy('id', 'desc')->paginate(10);
        // $products = Product::inRandomOrder()->paginate(10);
        }

        return view('products.index', ['products' => $products]);
    }

    public function show(string $slug, Product $product) {
        $expectedSlug = $product->getSlug();
        $stock = $product->stock === 0 ? 'Indisponible' : 'Disponible';
        if ($slug !== $expectedSlug) {
            return to_route('product.show', [
                'slug' => $expectedSlug,
                'product' => $product
            ]); 
        }

        return view('products.show', [
            'product' => $product,
            'stock' => $stock
        ]);
    }
}
