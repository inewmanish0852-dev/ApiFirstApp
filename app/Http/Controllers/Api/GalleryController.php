<?php
// app/Http/Controllers/Api/GalleryController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponse;

class GalleryController extends Controller
{
    use ApiResponse;
    public function index()
    {
        return $this->success([
            ['id' => 1, 'title' => 'Wireless Headphones',  'category' => 'Products', 'image' => 'https://via.placeholder.com/400x400?text=Headphones'],
            ['id' => 2, 'title' => 'T-Shirt Collection',   'category' => 'Products', 'image' => 'https://via.placeholder.com/400x400?text=T-Shirt'],
            ['id' => 3, 'title' => 'Smartphone Pro Max',   'category' => 'Products', 'image' => 'https://via.placeholder.com/400x400?text=Smartphone'],
            ['id' => 4, 'title' => 'Leather Backpack',     'category' => 'Products', 'image' => 'https://via.placeholder.com/400x400?text=Backpack'],
            ['id' => 5, 'title' => 'Smart Watch',          'category' => 'Products', 'image' => 'https://via.placeholder.com/400x400?text=SmartWatch'],
            ['id' => 6, 'title' => 'Our Office',           'category' => 'Team',     'image' => 'https://via.placeholder.com/400x400?text=Office'],
            ['id' => 7, 'title' => 'Team Meeting',         'category' => 'Team',     'image' => 'https://via.placeholder.com/400x400?text=Team'],
            ['id' => 8, 'title' => 'Warehouse',            'category' => 'Team',     'image' => 'https://via.placeholder.com/400x400?text=Warehouse'],
        ], 'Gallery fetched successfully');
    }
}