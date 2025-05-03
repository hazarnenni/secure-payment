<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Cookie;
use App\Models\Product;


class PaymentController extends Controller
{
    public function checkout(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        $cart = json_decode(Cookie::get('cart', '[]'), true);
        $lineItems = [];

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $product->name,
                        ],
                        'unit_amount' => intval($product->price * 100),
                    ],
                    'quantity' => $item['quantity'],
                ];
            }
        }
        $lineItems[] = [
            'price_data' => [
                'currency' => 'usd',
                'product_data' => ['name' => 'Shipping'],
                'unit_amount' => 999,
            ],
            'quantity' => 1,
        ];

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'automatic_tax' => ['enabled' => true],
            'success_url' => route('checkout.success'),
            'cancel_url' => route('checkout.cancel'),
        ]);

        return redirect($session->url);
    }
}
