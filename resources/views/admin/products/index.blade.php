@extends('admin.layouts.app')
@section('title', 'Products')
@section('page-title', 'Products')

@section('content')
<div class="page-header fade-up">
  <div>
    <div class="breadcrumb">Home / <span>Products</span></div>
    <h1>Products</h1>
    <p>Manage your product catalogue</p>
  </div>
  <div style="display:flex;gap:10px;">
    <button class="btn btn-ghost"><i class="fas fa-filter"></i> Filter</button>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Product</a>
  </div>
</div>

<!-- Stats Row -->
<div class="stats-grid fade-up" style="grid-template-columns:repeat(4,1fr);margin-bottom:20px;">
  @foreach([['Total Products','86','fas fa-box','accent'],['In Stock','72','fas fa-check-circle','green'],['Low Stock','8','fas fa-exclamation-triangle','orange'],['Out of Stock','6','fas fa-times-circle','red']] as $s)
  <div class="stat-card">
    <div class="stat-icon" style="background:var(--{{ $s[3] }})25;"><i class="{{ $s[2] }}" style="color:var(--{{ $s[3] }})"></i></div>
    <div class="stat-label">{{ $s[0] }}</div>
    <div class="stat-value" style="font-size:22px;">{{ $s[1] }}</div>
  </div>
  @endforeach
</div>

<div class="card fade-up-2">
  <!-- Search & Filter Bar -->
  <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="flex:1;min-width:200px;display:flex;align-items:center;gap:8px;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:9px 14px;">
      <i class="fas fa-search" style="color:var(--text-dim);font-size:13px;"></i>
      <input type="text" placeholder="Search products…" style="background:none;border:none;outline:none;color:var(--text);font-size:13px;font-family:var(--font);width:100%;" id="productSearch">
    </div>
    <select style="background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:9px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
      <option>All Categories</option>
      <option>Electronics</option>
      <option>Clothing</option>
      <option>Bags</option>
    </select>
    <select style="background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:9px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
      <option>All Status</option>
      <option>In Stock</option>
      <option>Low Stock</option>
      <option>Out of Stock</option>
    </select>
  </div>

  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Product</th>
          <th>Category</th>
          <th>Price</th>
          <th>Stock</th>
          <th>Rating</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($products ?? [] as $product)
        <tr>
          <td style="color:var(--text-dim);font-size:12px;">{{ $product->id }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:40px;height:40px;border-radius:10px;background:var(--navy-light);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">
                {{ $product->category === 'Electronics' ? '📱' : ($product->category === 'Clothing' ? '👕' : '🎒') }}
              </div>
              <div>
                <div style="font-weight:600;color:var(--text);">{{ Str::limit($product->title,36) }}</div>
                <div style="font-size:11px;color:var(--text-dim);">{{ $product->slug }}</div>
              </div>
            </div>
          </td>
          <td><span class="pill pill-blue">{{ $product->category }}</span></td>
          <td style="font-weight:700;color:var(--green);">₹{{ number_format($product->price) }}</td>
          <td>{{ $product->stock }}</td>
          <td><span style="color:#F59E0B;">★</span> {{ $product->rating }}</td>
          <td>
            @if($product->stock > 10) <span class="pill pill-green">In Stock</span>
            @elseif($product->stock > 0) <span class="pill pill-orange">Low Stock</span>
            @else <span class="pill pill-red">Out of Stock</span>
            @endif
          </td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-ghost btn-sm"><i class="fas fa-pen"></i></a>
              <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Delete this product?')">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        @foreach([
          [1,'Smartphone Pro Max','Electronics','₹49,999',12,4.8,'In Stock'],
          [2,'Wireless Headphones','Electronics','₹2,999',24,4.5,'In Stock'],
          [3,'Smart Watch Series 5','Electronics','₹8,999',30,4.6,'In Stock'],
          [4,'Leather Backpack','Bags','₹3,499',5,4.3,'Low Stock'],
          [5,'Premium Cotton T-Shirt','Clothing','₹599',58,4.2,'In Stock'],
        ] as $p)
        <tr>
          <td style="color:var(--text-dim);font-size:12px;">{{ $p[0] }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:10px;">
              <div style="width:40px;height:40px;border-radius:10px;background:var(--navy-light);display:flex;align-items:center;justify-content:center;font-size:18px;">
                {{ $p[2]==='Electronics'?'📱':($p[2]==='Clothing'?'👕':'🎒') }}
              </div>
              <div>
                <div style="font-weight:600;color:var(--text);">{{ $p[1] }}</div>
                <div style="font-size:11px;color:var(--text-dim);">{{ strtolower(str_replace(' ','-',$p[1])) }}</div>
              </div>
            </div>
          </td>
          <td><span class="pill pill-blue">{{ $p[2] }}</span></td>
          <td style="font-weight:700;color:var(--green);">{{ $p[3] }}</td>
          <td style="{{ $p[5]==='Low Stock'?'color:var(--orange);font-weight:700;':'' }}">{{ $p[4] }}</td>
          <td><span style="color:#F59E0B;">★</span> {{ $p[5] }}</td>
          <td><span class="pill pill-{{ $p[6]==='In Stock'?'green':'orange' }}">{{ $p[6] }}</span></td>
          <td>
            <div style="display:flex;gap:6px;">
              <button class="btn btn-ghost btn-sm"><i class="fas fa-pen"></i></button>
              <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
            </div>
          </td>
        </tr>
        @endforeach
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection