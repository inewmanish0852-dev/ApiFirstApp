<?php
// app/Http/Controllers/Api/ReviewController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class ReviewController extends Controller
{
    use ApiResponse;
    private function reviews(): array
    {
        return [
            ['id' => 1, 'product_id' => 1, 'user' => 'John D.',  'avatar' => 'JD', 'color' => '#1A3C6E', 'rating' => 5, 'comment' => 'Excellent product! Fast delivery and great quality. Highly recommended!', 'date' => 'Jan 10, 2024'],
            ['id' => 2, 'product_id' => 1, 'user' => 'Alice S.',  'avatar' => 'AS', 'color' => '#E67E22', 'rating' => 4, 'comment' => 'Good quality, slightly delayed shipping but overall great experience.', 'date' => 'Jan 8, 2024'],
            ['id' => 3, 'product_id' => 1, 'user' => 'Bob K.',    'avatar' => 'BK', 'color' => '#9B59B6', 'rating' => 5, 'comment' => 'Amazing sound quality! Worth every rupee.', 'date' => 'Jan 6, 2024'],
            ['id' => 4, 'product_id' => 2, 'user' => 'Priya M.',  'avatar' => 'PM', 'color' => '#27AE60', 'rating' => 4, 'comment' => 'Very comfortable and soft material. Good fit!', 'date' => 'Jan 5, 2024'],
            ['id' => 5, 'product_id' => 3, 'user' => 'Ravi T.',   'avatar' => 'RT', 'color' => '#E74C3C', 'rating' => 5, 'comment' => 'Best smartphone I have ever used. Camera is outstanding!', 'date' => 'Jan 3, 2024'],
        ];
    }

    public function index($productId)
    {
        $reviews = collect($this->reviews())->where('product_id', (int)$productId)->values()->all();
        $avgRating = count($reviews) ? round(collect($reviews)->avg('rating'), 1) : 0;

        return $this->success([
            'reviews'    => $reviews,
            'total'      => count($reviews),
            'avg_rating' => $avgRating,
        ], 'Reviews fetched successfully');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'rating'     => 'required|integer|min:1|max:5',
            'comment'    => 'required|string|min:10',
        ]);

        return $this->success([
            'id'         => rand(100, 999),
            'product_id' => $request->product_id,
                'rating'     => $request->rating,
                'comment'    => $request->comment,
                'date'       => now()->format('M d, Y'),
            ],'Review submitted successfully!',
        );
    }
}