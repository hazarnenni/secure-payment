<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        $productIds = collect($cart)->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get();

        $cartItems = [];
        foreach ($cart as $item) {
            $product = $products->firstWhere('id', $item['product_id']);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                ];
            }
        }
        return view('cart.index', ['cartItems' => collect($cartItems)]);
    }
    public function addToCart(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        $found = false;
        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] += 1;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'product_id' => $productId,
                'quantity' => 1,
            ];
        }

        Cookie::queue('cart', json_encode($cart), 60 * 24 * 7);
        return response()
        ->json(['status' => 'success',
        'message' => 'Product added to cart']);
    }

    public function removeFromCart(Request $request, $productId)
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true);

        $cart = array_filter($cart, function ($item) use ($productId) {
            return $item['product_id'] != $productId;
        });

        $newCart = array_values($cart);

        $response = response()->json(['status' => 'success', 'message' => 'Product removed from cart!']);

        return $response->cookie('cart', json_encode($newCart), 60 * 24 * 30);
    }

    public function updateCart(Request $request, $productId)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);

        $cart = json_decode($request->cookie('cart', '[]'), true);

        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] = $request->quantity;
                break;
            }
        }

        return back()
            ->with('success', 'Cart updated!')
            ->cookie('cart', json_encode($cart), 60 * 24 * 30);
    }
    public function count(){
        $cart = json_decode(Cookie::get('cart', '[]'), true);
        $count = collect($cart)->sum('quantity');
        return response()->json(['count' => $count]);
    }
}
