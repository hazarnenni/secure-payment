<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Welcome to My Store</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Styles -->
        <style>
            /* Base styles */
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

            .hero {
                min-height: 100vh;
                display: flex;
                flex-direction: column;
                background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%);
            }

            .navbar {
                padding: 1.5rem 2rem;
                display: flex;
                justify-content: flex-end;
                z-index: 10;
            }

            .nav-links a {
                margin-left: 1.5rem;
                font-weight: 600;
                color: #475569;
                text-decoration: none;
                transition: color 0.3s ease;
            }

            .nav-links a:hover {
                color: #1e40af;
            }

            .main-content {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
                text-align: center;
            }

            .hero-content {
                max-width: 800px;
                padding: 2rem;
            }

            .hero-title {
                font-size: 4rem;
                font-weight: 800;
                margin-bottom: 1.5rem;
                background: linear-gradient(90deg, #1e40af, #3b82f6);
                -webkit-background-clip: text;
                background-clip: text;
                color: transparent;
                line-height: 1.1;
            }

            .hero-subtitle {
                font-size: 1.5rem;
                color: #475569;
                margin-bottom: 2.5rem;
                font-weight: 400;
            }

            .cta-button {
                display: inline-block;
                background: linear-gradient(90deg, #1e40af, #3b82f6);
                color: white;
                padding: 1rem 2.5rem;
                border-radius: 9999px;
                font-weight: 600;
                text-decoration: none;
                font-size: 1.125rem;
                transition: all 0.3s ease;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            }

            .cta-button:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }

            .features {
                padding: 5rem 2rem;
                background-color: white;
            }

            .features-grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
                gap: 2rem;
                max-width: 1200px;
                margin: 0 auto;
            }

            .feature-card {
                background: white;
                border-radius: 1rem;
                padding: 2rem;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
                transition: transform 0.3s ease;
            }

            .feature-card:hover {
                transform: translateY(-5px);
            }

            .feature-icon {
                font-size: 2.5rem;
                margin-bottom: 1.5rem;
                color: #3b82f6;
            }

            .feature-title {
                font-size: 1.25rem;
                font-weight: 700;
                margin-bottom: 1rem;
                color: #1e293b;
            }

            .feature-text {
                color: #64748b;
            }

            footer {
                background-color: #1e293b;
                color: white;
                padding: 2rem;
                text-align: center;
            }

            @media (max-width: 768px) {
                .hero-title {
                    font-size: 2.5rem;
                }

                .hero-subtitle {
                    font-size: 1.25rem;
                }
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="hero">
            @if (Route::has('login'))
                <div class="navbar">
                    <div class="nav-links">
                        @auth
                            <a href="{{ url('/home') }}">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}">Register</a>
                            @endif
                        @endauth
                    </div>
                </div>
            @endif

            <div class="main-content">
                <div class="hero-content">
                    <h1 class="hero-title">Welcome to My Store</h1>
                    <p class="hero-subtitle">Discover amazing products at unbeatable prices. Quality you can trust, service you deserve.</p>
                    <a href="/shop" class="cta-button">
                        Shop Now <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
            </div>
        </div>

        <section class="features">
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-truck"></i>
                    </div>
                    <h3 class="feature-title">Fast Shipping</h3>
                    <p class="feature-text">Get your orders delivered quickly with our reliable shipping partners.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Secure Payments</h3>
                    <p class="feature-text">Shop with confidence using our secure payment processing system.</p>
                </div>

                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3 class="feature-title">24/7 Support</h3>
                    <p class="feature-text">Our customer service team is always ready to assist you with any questions.</p>
                </div>
            </div>
        </section>

        <footer>
            <p>&copy; {{ date('Y') }} My Store. All rights reserved.</p>
        </footer>
    </body>
</html>
