<?php
// database/seeders/DatabaseSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Review;
use App\Models\Gallery;
use App\Models\Notification;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. Admin ──────────────────────────────────────────────────────
        $admin = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@myapp.com',
            'password' => Hash::make('password'),
            'role'     => '1',
            'phone'    => '+91 9876543210',
            'city'     => 'Mumbai',
            'state'    => 'Maharashtra',
        ]);

        // ── 2. Regular Users ──────────────────────────────────────────────
        $usersData = [
            ['Rahul Kumar',  'rahul@email.com',  '+91 98765 43210', 'Mumbai',    'Maharashtra'],
            ['Priya Sharma', 'priya@email.com',  '+91 91234 56789', 'Delhi',     'Delhi'],
            ['Amit Mehta',   'amit@email.com',   '+91 87654 32109', 'Bangalore', 'Karnataka'],
            ['Sneha Rao',    'sneha@email.com',  '+91 76543 21098', 'Chennai',   'Tamil Nadu'],
            ['Ravi Tiwari',  'ravi@email.com',   '+91 65432 10987', 'Hyderabad', 'Telangana'],
        ];

        $users = collect($usersData)->map(fn($u) => User::create([
            'name'     => $u[0],
            'email'    => $u[1],
            'phone'    => $u[2],
            'city'     => $u[3],
            'state'    => $u[4],
            'address'  => '123 Main Street',
            'password' => Hash::make('password'),
            'role'     => '2',
        ]));

        // ── 3. Categories ─────────────────────────────────────────────────
        $cats = collect([
            ['Electronics', 'electronics', '📱'],
            ['Clothing',    'clothing',    '👕'],
            ['Bags',        'bags',        '🎒'],
        ])->map(fn($c) => Category::create([
            'name' => $c[0], 'slug' => $c[1], 'icon' => $c[2],
        ]));

        // ── 4. Products ───────────────────────────────────────────────────
        $productsData = [
            [$cats[0]->id, 'Wireless Noise-Cancelling Headphones', 2999,  4999,  24, 4.5, true,  ['S','M','L']],
            [$cats[1]->id, 'Premium Cotton T-Shirt',               599,   899,   58, 4.2, false, ['XS','S','M','L','XL']],
            [$cats[0]->id, 'Smartphone Pro Max',                   49999, 59999, 12, 4.8, true,  []],
            [$cats[2]->id, 'Leather Backpack',                     3499,  4999,   5, 4.3, false, []],
            [$cats[0]->id, 'Smart Watch Series 5',                 8999,  11999, 30, 4.6, true,  []],
        ];

        $products = collect($productsData)->map(fn($p) => Product::create([
            'category_id'    => $p[0],
            'title'          => $p[1],
            'slug'           => Str::slug($p[1]),
            'description'    => "High quality {$p[1]}. Premium build, excellent performance and great value for money.",
            'price'          => $p[2],
            'original_price' => $p[3],
            'discount'       => (int)(($p[3] - $p[2]) / $p[3] * 100),
            'stock'          => $p[4],
            'rating'         => $p[5],
            'is_featured'    => $p[6],
            'sizes'          => $p[7],
            'tags'           => ['trending', 'popular'],
            'is_active'      => true,
        ]));

        // ── 5. Cart (for user[0]) ─────────────────────────────────────────
        Cart::create(['user_id' => $users[0]->id, 'product_id' => $products[0]->id, 'quantity' => 2]);
        Cart::create(['user_id' => $users[0]->id, 'product_id' => $products[1]->id, 'quantity' => 1]);

        // ── 6. Orders ─────────────────────────────────────────────────────
        $ordersData = [
            [$users[0], 'delivered', 'paid', [[$products[0], 2], [$products[1], 1]]],
            [$users[1], 'shipped',   'paid', [[$products[2], 1]]],
            [$users[2], 'processing','paid', [[$products[0], 1], [$products[3], 1], [$products[4], 1]]],
            [$users[3], 'delivered', 'paid', [[$products[4], 1], [$products[1], 2]]],
            [$users[4], 'cancelled', 'refunded', [[$products[1], 1]]],
        ];

        foreach ($ordersData as [$user, $status, $payStatus, $items]) {
            $subtotal = collect($items)->sum(fn($i) => $i[0]->price * $i[1]);
            $delivery = $subtotal >= 500 ? 0 : 99;

            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => Order::generateOrderNumber(),
                'status'           => $status,
                'payment_method'   => 'upi',
                'payment_status'   => $payStatus,
                'subtotal'         => $subtotal,
                'delivery_charge'  => $delivery,
                'discount_amount'  => 0,
                'total'            => $subtotal + $delivery,
                'shipping_name'    => $user->name,
                'shipping_phone'   => $user->phone,
                'shipping_address' => $user->address ?? '123 Main St',
                'shipping_city'    => $user->city,
                'shipping_state'   => $user->state,
                'shipping_pincode' => $user->pincode,
                'delivered_at'     => $status === 'delivered' ? now()->subDays(2) : null,
            ]);

            foreach ($items as [$product, $qty]) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'product_id' => $product->id,
                    'title'      => $product->title,
                    'price'      => $product->price,
                    'quantity'   => $qty,
                ]);
            }
        }

        // ── 7. Chats ──────────────────────────────────────────────────────
        foreach ($users->take(3) as $user) {
            $chat = Chat::create([
                'user_id'         => $user->id,
                'subject'         => 'Order Support',
                'is_open'         => true,
                'last_message'    => 'Hi! How can I help you?',
                'last_message_at' => now()->subMinutes(rand(1, 120)),
                'unread_admin'    => rand(0, 3),
            ]);

            ChatMessage::insert([
                [
                    'chat_id'     => $chat->id,
                    'sender_type' => 'admin',
                    'message'     => 'Hello! Welcome to MyApp Support. How can I help you?',
                    'is_read'     => true,
                    'created_at'  => now()->subMinutes(30),
                    'updated_at'  => now()->subMinutes(30),
                ],
                [
                    'chat_id'     => $chat->id,
                    'sender_type' => 'user',
                    'message'     => 'Hi! I want to know the status of my order.',
                    'is_read'     => false,
                    'created_at'  => now()->subMinutes(10),
                    'updated_at'  => now()->subMinutes(10),
                ],
            ]);
        }

        // ── 8. Reviews ────────────────────────────────────────────────────
        $reviewsData = [
            [$users[0], $products[0], 5, 'Amazing sound quality! Best headphones I have ever used.'],
            [$users[1], $products[0], 4, 'Good quality, noise cancellation works great. Slightly delayed shipping.'],
            [$users[2], $products[2], 5, 'Best smartphone I have ever used! Camera is exceptional.'],
            [$users[3], $products[1], 4, 'Very comfortable and soft material. True to size.'],
            [$users[4], $products[4], 5, 'Worth every rupee. Great smartwatch with excellent battery life!'],
            [$users[0], $products[3], 4, 'Very sturdy and spacious backpack. Fits a 15" laptop easily.'],
        ];

        foreach ($reviewsData as [$user, $product, $rating, $comment]) {
            Review::create([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'rating'     => $rating,
                'comment'    => $comment,
                'is_approved'=> true,
            ]);
        }

        // ── 9. Gallery ────────────────────────────────────────────────────
        $galleryData = [
            ['Wireless Headphones Front',   'Products'],
            ['Premium T-Shirt Collection',  'Products'],
            ['Smartphone Pro Max',          'Products'],
            ['Leather Backpack Full View',  'Products'],
            ['Smart Watch Display',         'Products'],
            ['Our Office Space',            'Team'],
            ['Team Meeting',                'Team'],
            ['Warehouse & Packing',         'Team'],
        ];

        foreach ($galleryData as $i => [$title, $cat]) {
            Gallery::create([
                'title'      => $title,
                'category'   => $cat,
                'image'      => 'gallery/placeholder.jpg',
                'sort_order' => $i + 1,
                'is_active'  => true,
            ]);
        }

        // ── 10. Notifications ─────────────────────────────────────────────
        $notifData = [
            [$users[0]->id, '📦', 'Order Shipped!',    'Your order ORD-2024-002 is on its way. Track it now.', 'order',   false],
            [$users[0]->id, '🎉', 'Order Confirmed!',  'Your order has been placed successfully.',             'order',   true],
            [null,          '🎁', 'Special Offer!',    'Get 30% off on all Electronics today only!',           'promo',   false],
            [$users[1]->id, '⭐', 'Rate Your Purchase','How was your Smartphone Pro Max? Leave a review!',     'review',  false],
            [null,          '🔔', 'App Update',        'MyApp v2.0 is available. Update now for new features!','general', true],
        ];

        foreach ($notifData as [$uid, $icon, $title, $body, $type, $read]) {
            Notification::create([
                'user_id'    => $uid,
                'icon'       => $icon,
                'title'      => $title,
                'body'       => $body,
                'type'       => $type,
                'is_read'    => $read,
                'created_at' => now()->subDays(rand(0, 7)),
            ]);
        }

        $this->command->info('');
        $this->command->info('✅  Database seeded successfully!');
        $this->command->info('─────────────────────────────────');
        $this->command->info('   Admin → admin@myapp.com / password');
        $this->command->info('   User  → rahul@email.com / password');
        $this->command->info('─────────────────────────────────');
    }
}