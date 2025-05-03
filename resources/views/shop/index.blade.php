@extends('fixe')
@section('title', 'Shop')
@section('body')
<!-- Shop Hero -->
<section class="shop-hero">
    <h1>Discover Our Products</h1>
    <p>Explore our carefully curated collection of high-quality products that combine style, functionality, and value.</p>
</section>

<!-- Filter & Search -->
<div class="shop-tools">
    <div class="search-box">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search products...">
    </div>
    <button class="filter-btn">
        <i class="fas fa-sliders-h"></i>
        Filters
    </button>
</div>
<main class="products">
    <div class="product-grid">
        @foreach($products as $product)
        <div class="product-card">
            <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="product-image">
            <div class="product-info">
                <span class="product-category">{{ $product->category }}</span>
                <h3 class="product-title">{{ $product->name }}</h3>
                <div class="product-rating">
                    <div class="stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->rating))
                                <i class="fas fa-star"></i>
                            @elseif($i == ceil($product->rating) && $product->rating != floor($product->rating))
                                <i class="fas fa-star-half-alt"></i>
                            @else
                                <i class="far fa-star"></i>
                            @endif
                        @endfor
                    </div>
                    <span class="review-count">({{ $product->review_count }})</span>
                </div>
                <div class="product-price">${{ number_format($product->price, 2) }}</div>
                <button class="add-to-cart" data-product-id="{{ $product->id }}">Add to Cart</button>
            </div>
        </div>
        @endforeach
    </div>
</main>
@endsection
