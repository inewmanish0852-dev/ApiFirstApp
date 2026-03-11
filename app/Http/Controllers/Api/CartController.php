<?php
// app/Http/Controllers/Api/CartController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponse;

class CartController extends Controller
{
    use ApiResponse;
    // NOTE: In production, store cart in DB per user.
    // Using session-based static demo data here.

    private function staticCart(): array
    {
        return [
            [
                'id'         => 1,
                'product_id' => 1,
                'title'      => 'Wireless Noise-Cancelling Headphones',
                'price'      => 2999,
                'quantity'   => 2,
                'subtotal'   => 5998,
                'image'      => 'https://via.placeholder.com/200x200?text=Headphones',
                'size'       => 'One Size',
            ],
            [
                'id'         => 2,
                'product_id' => 2,
                'title'      => 'Premium Cotton T-Shirt',
                'price'      => 599,
                'quantity'   => 1,
                'subtotal'   => 599,
                'image'      => 'https://via.placeholder.com/200x200?text=T-Shirt',
                'size'       => 'M',
            ],
            [
                'id'         => 3,
                'product_id' => 5,
                'title'      => 'Smart Watch Series 5',
                'price'      => 8999,
                'quantity'   => 1,
                'subtotal'   => 8999,
                'image'      => 'https://via.placeholder.com/200x200?text=SmartWatch',
                'size'       => 'One Size',
            ],
        ];
    }

    public function index()
    {
        $items    = $this->staticCart();
        $subtotal = collect($items)->sum('subtotal');
        $delivery = $subtotal > 500 ? 0 : 99;
        $total    = $subtotal + $delivery;

        return $this->success('Cart fetched successfully', [
            'items'    => $items,
            'count'    => count($items),
            'subtotal' => $subtotal,
                'delivery' => $delivery,
                'total'    => $total,
            ],
        );
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity'   => 'required|integer|min:1',
        ]);

        return $this->success('Item added to cart',[
            'status'  => true,
            'message' => 'Item added to cart',
            'data'    => [
                'id'         => rand(10, 99),
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|integer',
            'quantity'     => 'required|integer|min:1',
        ]);

        return $this->success('Cart updated',[
            'status'  => true,
            'message' => 'Cart updated',
        ]);
    }

    public function remove($id)
    {
        return $this->success('Item removed from cart',[
            'status'  => true,
            'message' => 'Item removed from cart',
        ]);
    }

    public function clear()
    {
        return $this->success('Cart cleared',[
            'status'  => true,
            'message' => 'Cart cleared',
        ]);
    }
}