<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Premium Wireless Headphones',
                'description' => 'High-quality wireless headphones with rich sound and deep bass.',
                'price' => 149.99,
                'category' => 'Electronics',
                'image_url' => 'https://images.unsplash.com/photo-1546868871-7041f2a55e12',
                'rating' => 4.5,
                'review_count' => 128,
            ],
            [
                'name' => 'Smart Fitness Watch',
                'description' => 'Stylish smartwatch with fitness tracking and health monitoring features.',
                'price' => 199.99,
                'category' => 'Wearables',
                'image_url' => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30',
                'rating' => 4.0,
                'review_count' => 96,
            ],
            [
                'name' => 'Noise Cancelling Headphones',
                'description' => 'Experience immersive sound with active noise cancellation.',
                'price' => 249.99,
                'category' => 'Electronics',
                'image_url' => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e',
                'rating' => 5.0,
                'review_count' => 215,
            ],
            [
                'name' => 'Pro Running Shoes',
                'description' => 'Lightweight and comfortable shoes for serious runners.',
                'price' => 129.99,
                'category' => 'Footwear',
                'image_url' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff',
                'rating' => 4.5,
                'review_count' => 178,
            ],
            [
                'name' => 'Polarized Sunglasses',
                'description' => 'Protect your eyes with stylish polarized lenses.',
                'price' => 89.99,
                'category' => 'Accessories',
                'image_url' => 'https://images.unsplash.com/photo-1572635196237-14b3f281503f',
                'rating' => 4.0,
                'review_count' => 64,
            ],
            [
                'name' => 'Travel Backpack',
                'description' => 'Durable and spacious backpack perfect for travel.',
                'price' => 79.99,
                'category' => 'Bags',
                'image_url' => 'https://images.unsplash.com/photo-1525904097878-94fb15835963',
                'rating' => 5.0,
                'review_count' => 342,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
