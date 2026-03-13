@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@push('styles')
<style>
  .sparkline { display: flex; align-items: flex-end; gap: 3px; height: 36px; }
  .sparkline-bar { width: 6px; border-radius: 3px; background: var(--accent); opacity: .4; flex-shrink: 0; transition: opacity .2s; }
  .sparkline-bar.active { opacity: 1; }
  .sparkline-bar:hover { opacity: 1; }
  .activity-item { display: flex; align-items: flex-start; gap: 12px; padding: 12px 0; border-bottom: 1px solid var(--border); }
  .activity-item:last-child { border-bottom: none; }
  .activity-dot { width: 10px; height: 10px; border-radius: 50%; margin-top: 4px; flex-shrink: 0; }
  .top-product { display: flex; align-items: center; gap: 14px; padding: 10px 0; border-bottom: 1px solid var(--border); }
  .top-product:last-child { border-bottom: none; }
  .top-product-rank { width: 24px; height: 24px; border-radius: 8px; background: var(--navy-light); font-size: 11px; font-weight: 800; color: var(--text-mid); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
  .top-product-rank.gold { background: #F59E0B25; color: var(--orange); }
  .progress-bar { height: 6px; background: var(--navy-light); border-radius: 10px; overflow: hidden; }
  .progress-fill { height: 100%; border-radius: 10px; background: linear-gradient(90deg, var(--accent), #2563EB); }
  .order-mini { display: flex; align-items: center; gap: 12px; padding: 11px 0; border-bottom: 1px solid var(--border); }
  .order-mini:last-child { border-bottom: none; }
</style>
@endpush

@section('content')
<div class="page-header fade-up">
  <div>
    <div class="breadcrumb">Home / <span>Dashboard</span></div>
    <h1>Welcome back, Admin 👋</h1>
    <p>Here's what's happening with your store today.</p>
  </div>
  <div style="display:flex;gap:10px;">
    <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost"><i class="fas fa-receipt"></i> View Orders</a>
    <button class="btn btn-primary"><i class="fas fa-download"></i> Export Report</button>
  </div>
</div>

<!-- ── STAT CARDS ─────────────────────────────────────────────────────── -->
<div class="stats-grid">
  <div class="stat-card fade-up">
    <div class="stat-icon" style="background:#4A90D920;"><i class="fas fa-shopping-bag" style="color:var(--accent)"></i></div>
    <div class="stat-label">Total Orders</div>
    <div class="stat-value">{{ $stats['total_orders'] ?? 248 }}</div>
    <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 12% from last month</div>
  </div>
  <div class="stat-card fade-up-2">
    <div class="stat-icon" style="background:#10B98120;"><i class="fas fa-rupee-sign" style="color:var(--green)"></i></div>
    <div class="stat-label">Total Revenue</div>
    <div class="stat-value">₹{{ number_format($stats['total_revenue'] ?? 182450) }}</div>
    <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 8.3% from last month</div>
  </div>
  <div class="stat-card fade-up-3">
    <div class="stat-icon" style="background:#8B5CF620;"><i class="fas fa-users" style="color:var(--purple)"></i></div>
    <div class="stat-label">Total Users</div>
    <div class="stat-value">{{ $stats['total_users'] ?? 1340 }}</div>
    <div class="stat-trend up"><i class="fas fa-arrow-up"></i> 5.1% new this week</div>
  </div>
  <div class="stat-card fade-up-4">
    <div class="stat-icon" style="background:#F59E0B20;"><i class="fas fa-box" style="color:var(--orange)"></i></div>
    <div class="stat-label">Total Products</div>
    <div class="stat-value">{{ $stats['total_products'] ?? 86 }}</div>
    <div class="stat-trend down"><i class="fas fa-arrow-down"></i> 3 low stock alerts</div>
  </div>
</div>

<!-- ── ROW 2 ───────────────────────────────────────────────────────────── -->
<div class="grid-2 fade-up-2" style="margin-bottom:20px;">

  <!-- Recent Orders -->
  <div class="card">
    <div class="card-title">
      Recent Orders
      <a href="{{ route('admin.orders.index') }}" class="btn btn-ghost btn-sm">View All</a>
    </div>
    <div class="table-wrap">
      <table>
        <thead><tr>
          <th>Order</th><th>Customer</th><th>Amount</th><th>Status</th>
        </tr></thead>
        <tbody>
          @forelse($recent_orders ?? [] as $order)
          <tr>
            <td style="font-family:var(--mono);color:var(--accent);font-size:12px;">{{ $order->order_number }}</td>
            <td>{{ $order->user->name ?? 'N/A' }}</td>
            <td style="font-weight:700;">₹{{ number_format($order->total) }}</td>
            <td>
              @php $sc = ['delivered'=>'green','shipped'=>'orange','processing'=>'blue','cancelled'=>'red'][$order->status] ?? 'blue'; @endphp
              <span class="pill pill-{{ $sc }}">{{ ucfirst($order->status) }}</span>
            </td>
          </tr>
          @empty
          @foreach([['ORD-001','Rahul K.','₹2,999','delivered'],['ORD-002','Priya S.','₹49,999','shipped'],['ORD-003','Amit M.','₹8,999','processing'],['ORD-004','Sneha R.','₹3,499','processing'],['ORD-005','Ravi T.','₹599','delivered']] as $r)
          <tr>
            <td style="font-family:var(--mono);color:var(--accent);font-size:12px;">{{ $r[0] }}</td>
            <td>{{ $r[1] }}</td>
            <td style="font-weight:700;">{{ $r[2] }}</td>
            <td><span class="pill pill-{{ $r[3]==='delivered'?'green':($r[3]==='shipped'?'orange':'blue') }}">{{ ucfirst($r[3]) }}</span></td>
          </tr>
          @endforeach
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Top Products -->
  <div class="card">
    <div class="card-title">
      Top Products
      <a href="{{ route('admin.products.index') }}" class="btn btn-ghost btn-sm">View All</a>
    </div>
    @foreach([
      ['Smartphone Pro Max','Electronics','₹49,999','256 sold',92],
      ['Wireless Headphones','Electronics','₹2,999','128 sold',72],
      ['Smart Watch Series 5','Electronics','₹8,999','89 sold',60],
      ['Leather Backpack','Bags','₹3,499','42 sold',35],
      ['Premium Cotton T-Shirt','Clothing','₹599','64 sold',28],
    ] as $i => $p)
    <div class="top-product">
      <div class="top-product-rank {{ $i===0?'gold':'' }}">{{ $i+1 }}</div>
      <div style="flex:1;min-width:0;">
        <div style="font-size:13px;font-weight:600;color:var(--text);margin-bottom:3px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p[0] }}</div>
        <div style="font-size:11px;color:var(--text-dim);">{{ $p[1] }} · {{ $p[2] }}</div>
        <div class="progress-bar" style="margin-top:6px;">
          <div class="progress-fill" style="width:{{ $p[4] }}%"></div>
        </div>
      </div>
      <div style="font-size:12px;font-weight:700;color:var(--green);flex-shrink:0;">{{ $p[3] }}</div>
    </div>
    @endforeach
  </div>
</div>

<!-- ── ROW 3 ───────────────────────────────────────────────────────────── -->
<div class="grid-3 fade-up-3">

  <!-- Order Status Breakdown -->
  <div class="card">
    <div class="card-title">Order Status</div>
    @foreach([
      ['Delivered', 142, 'green',  57],
      ['Shipped',    48, 'orange', 19],
      ['Processing', 38, 'blue',   15],
      ['Cancelled',  20, 'red',     8],
    ] as $s)
    <div style="margin-bottom:14px;">
      <div style="display:flex;justify-content:space-between;margin-bottom:5px;">
        <span class="pill pill-{{ $s[1] }}">{{ $s[0] }}</span>
        <span style="font-size:13px;font-weight:700;color:var(--text);">{{ $s[1] }} <span style="color:var(--text-dim);font-weight:400;">({{ $s[3] }}%)</span></span>
      </div>
      <div class="progress-bar">
        <div class="progress-fill" style="width:{{ $s[3] }}%;background:var(--{{ $s[1] === 'green' ? '--green' : '' }});"
          @if($s[1]==='green') style="background:var(--green);width:{{ $s[3] }}%"
          @elseif($s[1]==='orange') style="background:var(--orange);width:{{ $s[3] }}%"
          @elseif($s[1]==='red') style="background:var(--red);width:{{ $s[3] }}%"
          @endif
        ></div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Recent Reviews -->
  <div class="card">
    <div class="card-title">
      Recent Reviews
      <a href="{{ route('admin.reviews.index') }}" class="btn btn-ghost btn-sm">All</a>
    </div>
    @foreach([
      ['John D.','Wireless Headphones',5,'Amazing quality!'],
      ['Alice S.','Smartphone Pro Max',4,'Great camera.'],
      ['Bob K.','Smart Watch',5,'Worth every rupee.'],
      ['Priya M.','T-Shirt',3,'Good but late delivery.'],
    ] as $r)
    <div class="activity-item">
      <div style="width:32px;height:32px;border-radius:10px;background:var(--accent);opacity:.8;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;flex-shrink:0;">{{ substr($r[0],0,1) }}</div>
      <div style="flex:1;min-width:0;">
        <div style="font-size:13px;font-weight:600;color:var(--text);">{{ $r[0] }}</div>
        <div style="font-size:11px;color:var(--text-dim);margin-bottom:2px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $r[1] }}</div>
        <div style="color:#F59E0B;font-size:12px;">{{ str_repeat('★',$r[2]) }}{{ str_repeat('☆',5-$r[2]) }}</div>
      </div>
    </div>
    @endforeach
  </div>

  <!-- Recent Activity -->
  <div class="card">
    <div class="card-title">Recent Activity</div>
    @foreach([
      ['New order placed — ORD-2024-248','blue','2 min ago'],
      ['User Sneha R. registered','purple','15 min ago'],
      ['Review submitted for Headphones','orange','1 hr ago'],
      ['Order ORD-2024-246 delivered','green','2 hrs ago'],
      ['New chat message from Rahul','blue','3 hrs ago'],
      ['Product stock low — T-Shirt XL','red','5 hrs ago'],
    ] as $a)
    <div class="activity-item">
      <div class="activity-dot" style="background:var(--{{ $a[1]==='blue'?'accent':($a[1]==='green'?'green':($a[1]==='red'?'red':($a[1]==='orange'?'orange':'purple'))) }})"></div>
      <div style="flex:1;">
        <div style="font-size:13px;color:var(--text);line-height:1.4;">{{ $a[0] }}</div>
        <div style="font-size:11px;color:var(--text-dim);margin-top:2px;">{{ $a[2] }}</div>
      </div>
    </div>
    @endforeach
  </div>

</div>
@endsection