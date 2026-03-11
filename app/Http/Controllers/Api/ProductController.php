<?php
// app/Http/Controllers/Api/ProductController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ResponseTrait;

class ProductController extends Controller
{
    use ResponseTrait;
    private function products(): array
    {
        return [
            [
                'id'          => 1,
                'title'       => 'Wireless Noise-Cancelling Headphones',
                'slug'        => 'wireless-headphones',
                'description' => 'Premium over-ear headphones with 30hr battery life and active noise cancellation.',
                'price'       => 2999,
                'original_price' => 4999,
                'discount'    => 40,
                'stock'       => 24,
                'rating'      => 4.5,
                'reviews_count' => 128,
                'category'    => 'Electronics',
                'category_slug' => 'electronics',
                'image'       => 'https://via.placeholder.com/400x400?text=Headphones',
                'images'      => [
                    'https://via.placeholder.com/400x400?text=Headphones+1',
                    'https://via.placeholder.com/400x400?text=Headphones+2',
                ],
                'tags'        => ['wireless', 'audio', 'premium'],
                'is_featured' => true,
            ],
            [
                'id'          => 2,
                'title'       => 'Premium Cotton T-Shirt',
                'slug'        => 'premium-cotton-tshirt',
                'description' => '100% organic cotton, soft and breathable. Available in multiple sizes.',
                'price'       => 599,
                'original_price' => 899,
                'discount'    => 33,
                'stock'       => 58,
                'rating'      => 4.2,
                'reviews_count' => 64,
                'category'    => 'Clothing',
                'category_slug' => 'clothing',
                'image'       => 'https://via.placeholder.com/400x400?text=T-Shirt',
                'images'      => [
                    'https://via.placeholder.com/400x400?text=T-Shirt+1',
                    'https://via.placeholder.com/400x400?text=T-Shirt+2',
                ],
                'tags'        => ['fashion', 'cotton', 'casual'],
                'is_featured' => false,
            ],
            [
                'id'          => 3,
                'title'       => 'Smartphone Pro Max',
                'slug'        => 'smartphone-pro-max',
                'description' => '6.7" AMOLED display, 108MP camera, 5000mAh battery. Top of the line performance.',
                'price'       => 49999,
                'original_price' => 59999,
                'discount'    => 17,
                'stock'       => 12,
                'rating'      => 4.8,
                'reviews_count' => 256,
                'category'    => 'Electronics',
                'category_slug' => 'electronics',
                'image'       => 'https://via.placeholder.com/400x400?text=Smartphone',
                'images'      => [
                    'https://via.placeholder.com/400x400?text=Phone+1',
                    'https://via.placeholder.com/400x400?text=Phone+2',
                ],
                'tags'        => ['smartphone', '5G', 'camera'],
                'is_featured' => true,
            ],
            [
                'id'          => 4,
                'title'       => 'Leather Backpack',
                'slug'        => 'leather-backpack',
                'description' => 'Genuine leather backpack with laptop compartment. Perfect for work and travel.',
                'price'       => 3499,
                'original_price' => 4999,
                'discount'    => 30,
                'stock'       => 18,
                'rating'      => 4.3,
                'reviews_count' => 42,
                'category'    => 'Bags',
                'category_slug' => 'bags',
                'image'       => 'https://via.placeholder.com/400x400?text=Backpack',
                'images'      => [
                    'https://via.placeholder.com/400x400?text=Bag+1',
                ],
                'tags'        => ['leather', 'bag', 'travel'],
                'is_featured' => false,
            ],
            [
                'id'          => 5,
                'title'       => 'Smart Watch Series 5',
                'slug'        => 'smart-watch-series-5',
                'description' => 'Health monitoring, GPS, 7-day battery. Works with iOS & Android.',
                'price'       => 8999,
                'original_price' => 11999,
                'discount'    => 25,
                'stock'       => 30,
                'rating'      => 4.6,
                'reviews_count' => 89,
                'category'    => 'Electronics',
                'category_slug' => 'electronics',
                'image'       => 'https://via.placeholder.com/400x400?text=SmartWatch',
                'images'      => [
                    'https://via.placeholder.com/400x400?text=Watch+1',
                ],
                'tags'        => ['smartwatch', 'fitness', 'wearable'],
                'is_featured' => true,
            ],
        ];
    }

    private function getCategories(): array
    {
        return [
            ['id' => 1, 'name' => 'All',         'slug' => 'all',         'icon' => '🛍️'],
            ['id' => 2, 'name' => 'Electronics',  'slug' => 'electronics', 'icon' => '📱'],
            ['id' => 3, 'name' => 'Clothing',     'slug' => 'clothing',    'icon' => '👕'],
            ['id' => 4, 'name' => 'Bags',         'slug' => 'bags',        'icon' => '🎒'],
        ];
    }

    public function index()
    {
        return $this->success('Products fetched successfully', $this->products());
    }

    public function show($id)
    {
        $product = collect($this->products())->firstWhere('id', (int)$id);
        if (!$product) {
            return $this->error('Product not found', 404);
        }
        return $this->success('Product fetched successfully', $product);
    }

    public function byCategory($slug)
    {
        $products = $slug === 'all'
            ? $this->products()
            : collect($this->products())->where('category_slug', $slug)->values()->all();

        return $this->success('Products fetched successfully', $products);
    }

    public function categories()
    {
        return $this->success('Categories fetched successfully', $this->getCategories());
    }
}