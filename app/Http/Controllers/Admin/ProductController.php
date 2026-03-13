<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        // Search
        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        // Category filter
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Stock filter
        if ($request->filled('stock')) {
            match($request->stock) {
                'in_stock'     => $query->where('stock', '>', 10),
                'low_stock'    => $query->whereBetween('stock', [1, 10]),
                'out_of_stock' => $query->where('stock', 0),
                default        => null,
            };
        }

        $products   = $query->paginate(20)->withQueryString();
        $categories = Category::all();

        $stats = [
            'total'        => Product::count(),
            'in_stock'     => Product::where('stock', '>', 10)->count(),
            'low_stock'    => Product::whereBetween('stock', [1, 10])->count(),
            'out_of_stock' => Product::where('stock', 0)->count(),
        ];

        return view('admin.products.index', compact('products', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = Category::active()->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'sizes'          => 'nullable|array',
            'is_featured'    => 'nullable|boolean',
            'is_active'      => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['slug']        = Str::slug($data['title']) . '-' . Str::random(4);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $data['discount']    = $this->calcDiscount($data['price'], $data['original_price'] ?? null);

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', "Product \"{$data['title']}\" created successfully!");
    }

    public function edit(Product $product)
    {
        $categories = Category::active()->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'    => 'required|exists:categories,id',
            'title'          => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'original_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'sizes'          => 'nullable|array',
            'is_featured'    => 'nullable|boolean',
            'is_active'      => 'nullable|boolean',
            'image'          => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);
        $data['discount']    = $this->calcDiscount($data['price'], $data['original_price'] ?? null);

        $product->update($data);

        return redirect()->route('admin.products.index')
            ->with('success', "Product updated successfully!");
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted.');
    }

    // ── Private helpers ───────────────────────────────────────────────────
    private function calcDiscount(float $price, ?float $originalPrice): int
    {
        if (!$originalPrice || $originalPrice <= 0) return 0;
        return (int)(($originalPrice - $price) / $originalPrice * 100);
    }
}