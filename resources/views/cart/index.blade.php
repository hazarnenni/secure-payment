@extends('fixe')
@section('title', 'Cart')
@section('body')
    <!-- Cart Hero -->
    <section class="cart-hero">
        <h1>Your Shopping Cart</h1>
        <p>Review your items before checkout</p>
    </section>

    <!-- Cart Content -->
    <div class="cart-container">
        <!-- Cart Items -->
        <div class="cart-items">
            <div class="cart-header">
                <h2 class="cart-title">Your Items</h2>
                <span class="item-count">{{ $cartItems->sum('quantity') }} items</span>
            </div>

            @if($cartItems->isEmpty())
                <div class="empty-cart">
                    <div class="empty-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h2>Your cart is empty</h2>
                    <p>Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('index') }}" class="shop-btn">Continue Shopping</a>
                </div>
            @else
                @foreach($cartItems as $item)
                    <div class="cart-item">
                        <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="item-image">
                        <div class="item-details">
                            <div>
                                <h3 class="item-name">{{ $item['product']->name }}</h3>
                                <p class="item-category">{{ $item['product']->category }}</p>
                            </div>
                            <div class="item-actions">
                                <button class="remove-item" data-id="{{ $item['product']->id }}">
                                    <i class="fas fa-trash-alt"></i> Remove
                                </button>
                            </div>
                        </div>
                        <div class="item-price" data-product-id="{{ $item['product']->id }}">
                            <div class="price">${{ number_format($item['product']->price, 2) }}</div>
                            <div class="quantity-control" data-id="{{ $item['product']->id }}">
                                <button type="button" class="quantity-btn minus">-</button>
                                <input type="text" class="quantity-input" value="{{ $item['quantity'] }}">
                                <button type="button" class="quantity-btn plus">+</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        @unless($cartItems->isEmpty())
            <div class="order-summary">
                <h3 class="summary-title">Order Summary</h3>

                <div class="summary-row">
                    <span class="summary-label" id="summary-subtotal-label">
                        Subtotal ({{ $cartItems->sum('quantity') }} items)
                    </span>
                    <span class="summary-value" id="summary-subtotal-value">
                        ${{ number_format($cartItems->sum(fn($item) => $item['product']->price * $item['quantity']), 2) }}
                    </span>
                </div>

                <div class="summary-row">
                    <span class="summary-label">Shipping</span>
                    <span class="summary-value" id="summary-shipping-value">$9.99</span>
                </div>

                <div class="summary-row total-row">
                    <span>Total</span>
                    <span class="summary-value" id="summary-total-value">
                        ${{ number_format($cartItems->sum(fn($item) => $item['product']->price * $item['quantity']) + 9.99, 2) }}
                    </span>
                </div>
                <form action="{{ route('stripe.checkout') }}" method="POST" id="checkout-form">
                    @csrf
                    <button type="submit" class="checkout-btn">Proceed to Checkout</button>
                </form>
                <a href="/shop" class="continue-shopping">
                    <i class="fas fa-arrow-left"></i> Continue Shopping
                </a>
            </div>
            @endunless

    </div>

@endsection
