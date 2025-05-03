<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Cart | My Store</title>

    <!-- Fonts & Icons -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --secondary: #f59e0b;
            --success: #10b981;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #94a3b8;
            --gray-light: #e2e8f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            line-height: 1.6;
        }

        /* Header */
        .header {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.5rem 2rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-dark);
            text-decoration: none;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
        }

        .nav-links a {
            color: var(--dark);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: var(--primary);
        }

        .cart-icon {
            position: relative;
        }

        .cart-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background-color: var(--secondary);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Cart Hero */
        .cart-hero {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            padding: 3rem 2rem;
            text-align: center;
        }

        .cart-hero h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--primary-dark);
        }

        .cart-hero p {
            font-size: 1.125rem;
            color: var(--dark);
            max-width: 700px;
            margin: 0 auto;
        }

        /* Cart Layout */
        .cart-container {
            max-width: 1400px;
            margin: 2rem auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 2rem;
        }

        @media (max-width: 1024px) {
            .cart-container {
                grid-template-columns: 1fr;
            }
        }

        /* Cart Items */
        .cart-items {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        .cart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-light);
        }

        .cart-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .item-count {
            color: var(--gray);
            font-weight: 500;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto;
            gap: 1.5rem;
            padding: 1.5rem 0;
            border-bottom: 1px solid var(--gray-light);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .item-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .item-name {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .item-category {
            color: var(--gray);
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .item-actions {
            display: flex;
            gap: 1rem;
        }

        .remove-item {
            color: var(--danger);
            background: none;
            border: none;
            font-size: 0.875rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .item-price {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .price {
            font-size: 1.125rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            border: 1px solid var(--gray-light);
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .quantity-btn {
            background: var(--gray-light);
            border: none;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-weight: 600;
        }

        .quantity-input {
            width: 40px;
            height: 30px;
            text-align: center;
            border: none;
            outline: none;
            font-weight: 500;
        }

        /* Order Summary */
        .order-summary {
            background: white;
            border-radius: 0.75rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            height: fit-content;
            position: sticky;
            top: 1rem;
        }

        .summary-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--gray-light);
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .summary-label {
            color: var(--gray);
        }

        .summary-value {
            font-weight: 500;
        }

        .total-row {
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid var(--gray-light);
            font-size: 1.125rem;
            font-weight: 600;
        }

        .checkout-btn {
            width: 100%;
            padding: 1rem;
            margin-top: 1.5rem;
            background: var(--success);
            color: white;
            border: none;
            border-radius: 0.5rem;
            font-weight: 600;
            font-size: 1.125rem;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .checkout-btn:hover {
            background: #0f9e6e;
        }

        .continue-shopping {
            display: inline-block;
            margin-top: 1rem;
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Empty Cart */
        .empty-cart {
            text-align: center;
            padding: 4rem 2rem;
            grid-column: 1 / -1;
        }

        .empty-cart-icon {
            font-size: 4rem;
            color: var(--gray-light);
            margin-bottom: 1.5rem;
        }

        .empty-cart h2 {
            font-size: 1.75rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: var(--dark);
        }

        .empty-cart p {
            color: var(--gray);
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .shop-btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: var(--primary);
            color: white;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.3s ease;
        }

        .shop-btn:hover {
            background: var(--primary-dark);
        }

        /* Footer */
        .footer {
            background: var(--dark);
            color: white;
            padding: 4rem 2rem;
            margin-top: 4rem;
        }

        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }

        .footer-column h3 {
            font-size: 1.125rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: var(--gray-light);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .footer-links a:hover {
            color: white;
        }

        .copyright {
            text-align: center;
            padding-top: 2rem;
            margin-top: 2rem;
            border-top: 1px solid rgba(255,255,255,0.1);
            color: var(--gray);
        }

        @media (max-width: 768px) {
            .navbar {
                padding: 1rem;
            }

            .nav-links {
                gap: 1rem;
            }

            .cart-item {
                grid-template-columns: 80px 1fr;
                grid-template-rows: auto auto;
                gap: 1rem;
            }

            .item-price {
                grid-column: 2;
                grid-row: 1;
                align-items: flex-start;
                flex-direction: row;
                gap: 1rem;
                align-items: center;
            }

            .price {
                margin-bottom: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <div class="navbar">
            <a href="/" class="logo">MyStore</a>
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="/shop">Shop</a>
                <a href="/about">About</a>
                <a href="/contact">Contact</a>
                <a href="/cart" class="cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count">3</span>
                </a>
            </div>
        </div>
    </header>

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
                <span class="item-count">3 items</span>
            </div>

            <!-- Item 1 -->
            <div class="cart-item">
                <img src="https://images.unsplash.com/photo-1546868871-7041f2a55e12" alt="Wireless Headphones" class="item-image">
                <div class="item-details">
                    <div>
                        <h3 class="item-name">Premium Wireless Headphones</h3>
                        <p class="item-category">Electronics</p>
                    </div>
                    <div class="item-actions">
                        <button class="remove-item">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </div>
                </div>
                <div class="item-price">
                    <div class="price">$149.99</div>
                    <div class="quantity-control">
                        <button class="quantity-btn">-</button>
                        <input type="text" class="quantity-input" value="1">
                        <button class="quantity-btn">+</button>
                    </div>
                </div>
            </div>

            <!-- Item 2 -->
            <div class="cart-item">
                <img src="https://images.unsplash.com/photo-1523275335684-37898b6baf30" alt="Smart Watch" class="item-image">
                <div class="item-details">
                    <div>
                        <h3 class="item-name">Smart Fitness Watch</h3>
                        <p class="item-category">Wearables</p>
                    </div>
                    <div class="item-actions">
                        <button class="remove-item">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </div>
                </div>
                <div class="item-price">
                    <div class="price">$199.99</div>
                    <div class="quantity-control">
                        <button class="quantity-btn">-</button>
                        <input type="text" class="quantity-input" value="1">
                        <button class="quantity-btn">+</button>
                    </div>
                </div>
            </div>

            <!-- Item 3 -->
            <div class="cart-item">
                <img src="https://images.unsplash.com/photo-1572635196237-14b3f281503f" alt="Sunglasses" class="item-image">
                <div class="item-details">
                    <div>
                        <h3 class="item-name">Polarized Sunglasses</h3>
                        <p class="item-category">Accessories</p>
                    </div>
                    <div class="item-actions">
                        <button class="remove-item">
                            <i class="fas fa-trash-alt"></i> Remove
                        </button>
                    </div>
                </div>
                <div class="item-price">
                    <div class="price">$89.99</div>
                    <div class="quantity-control">
                        <button class="quantity-btn">-</button>
                        <input type="text" class="quantity-input" value="1">
                        <button class="quantity-btn">+</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="order-summary">
            <h3 class="summary-title">Order Summary</h3>
            <div class="summary-row">
                <span class="summary-label">Subtotal (3 items)</span>
                <span class="summary-value">$439.97</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Shipping</span>
                <span class="summary-value">$9.99</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Tax</span>
                <span class="summary-value">$35.20</span>
            </div>
            <div class="summary-row total-row">
                <span>Total</span>
                <span>$485.16</span>
            </div>
            <button class="checkout-btn">Proceed to Checkout</button>
            <a href="/shop" class="continue-shopping">
                <i class="fas fa-arrow-left"></i> Continue Shopping
            </a>
        </div>
    </div>

    <!-- Empty Cart State (hidden by default) -->
    <!-- <div class="empty-cart">
        <div class="empty-cart-icon">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <h2>Your cart is empty</h2>
        <p>Looks like you haven't added any items to your cart yet. Start shopping to find amazing products!</p>
        <a href="/shop" class="shop-btn">Start Shopping</a>
    </div> -->

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <h3>Shop</h3>
                <ul class="footer-links">
                    <li><a href="#">All Products</a></li>
                    <li><a href="#">New Arrivals</a></li>
                    <li><a href="#">Featured</a></li>
                    <li><a href="#">Sale</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Customer Service</h3>
                <ul class="footer-links">
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Shipping & Returns</a></li>
                    <li><a href="#">Size Guide</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>About</h3>
                <ul class="footer-links">
                    <li><a href="#">Our Story</a></li>
                    <li><a href="#">Sustainability</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Press</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Connect</h3>
                <ul class="footer-links">
                    <li><a href="#"><i class="fab fa-facebook-f"></i> Facebook</a></li>
                    <li><a href="#"><i class="fab fa-instagram"></i> Instagram</a></li>
                    <li><a href="#"><i class="fab fa-twitter"></i> Twitter</a></li>
                    <li><a href="#"><i class="fab fa-pinterest"></i> Pinterest</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; 2023 MyStore. All rights reserved.
        </div>
    </footer>
</body>
</html>
