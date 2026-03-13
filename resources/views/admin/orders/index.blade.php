@extends('admin.layouts.app')
@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')
<div class="page-header fade-up">
  <div>
    <div class="breadcrumb">Home / <span>Orders</span></div>
    <h1>Orders</h1>
    <p>Manage and track all customer orders</p>
  </div>
  <button class="btn btn-primary"><i class="fas fa-download"></i> Export CSV</button>
</div>

<!-- Stats -->
<div class="stats-grid fade-up" style="margin-bottom:20px;">
  @foreach([['Total','248','fas fa-receipt','accent'],['Processing','38','fas fa-clock','orange'],['Shipped','48','fas fa-truck','blue'],['Delivered','142','fas fa-check','green']] as $s)
  <div class="stat-card">
    <div class="stat-icon" style="background:var(--{{ $s[3] }})25;"><i class="{{ $s[2] }}" style="color:var(--{{ $s[3] }})"></i></div>
    <div class="stat-label">{{ $s[0] }} Orders</div>
    <div class="stat-value" style="font-size:22px;">{{ $s[1] }}</div>
  </div>
  @endforeach
</div>

<div class="card fade-up-2">
  <div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;">
    <div style="flex:1;min-width:200px;display:flex;align-items:center;gap:8px;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:9px 14px;">
      <i class="fas fa-search" style="color:var(--text-dim);font-size:13px;"></i>
      <input type="text" placeholder="Search by order number or customer…" style="background:none;border:none;outline:none;color:var(--text);font-size:13px;font-family:var(--font);width:100%;">
    </div>
    <select style="background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:9px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
      <option>All Status</option>
      <option>Processing</option>
      <option>Shipped</option>
      <option>Delivered</option>
      <option>Cancelled</option>
    </select>
    <input type="date" style="background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:9px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;color-scheme:dark;">
  </div>

  <div class="table-wrap">
    <table>
      <thead><tr>
        <th>Order #</th><th>Customer</th><th>Items</th><th>Total</th><th>Payment</th><th>Status</th><th>Date</th><th>Actions</th>
      </tr></thead>
      <tbody>
        @forelse($orders ?? [] as $order)
        <tr>
          <td style="font-family:var(--mono);color:var(--accent);font-size:12px;">{{ $order->order_number }}</td>
          <td>{{ $order->user->name ?? '-' }}</td>
          <td>{{ $order->items_count }}</td>
          <td style="font-weight:700;">₹{{ number_format($order->total) }}</td>
          <td><span class="pill pill-green">Paid</span></td>
          <td>
            @php $sc = ['delivered'=>'green','shipped'=>'orange','processing'=>'blue','cancelled'=>'red'][$order->status] ?? 'blue'; @endphp
            <span class="pill pill-{{ $sc }}">{{ ucfirst($order->status) }}</span>
          </td>
          <td style="color:var(--text-mid);font-size:12px;">{{ $order->created_at->format('d M Y') }}</td>
          <td>
            <div style="display:flex;gap:6px;">
              <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></a>
              <a href="#" class="btn btn-ghost btn-sm"><i class="fas fa-file-invoice"></i></a>
            </div>
          </td>
        </tr>
        @empty
        @foreach([
          ['ORD-2024-001','Rahul Kumar',3,'₹6,597','delivered','10 Jan 2024'],
          ['ORD-2024-002','Priya Sharma',1,'₹49,999','shipped','14 Jan 2024'],
          ['ORD-2024-003','Amit Mehta',3,'₹15,596','processing','16 Jan 2024'],
          ['ORD-2024-004','Sneha Rao',2,'₹11,998','delivered','17 Jan 2024'],
          ['ORD-2024-005','Ravi Tiwari',1,'₹599','delivered','18 Jan 2024'],
        ] as $o)
        <tr>
          <td style="font-family:var(--mono);color:var(--accent);font-size:12px;">{{ $o[0] }}</td>
          <td>
            <div style="display:flex;align-items:center;gap:8px;">
              <div style="width:28px;height:28px;border-radius:8px;background:var(--accent);opacity:.7;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;flex-shrink:0;">{{ substr($o[1],0,1) }}</div>
              {{ $o[1] }}
            </div>
          </td>
          <td style="color:var(--text-mid);">{{ $o[2] }} item{{ $o[2]>1?'s':'' }}</td>
          <td style="font-weight:700;color:var(--green);">{{ $o[3] }}</td>
          <td><span class="pill pill-green">Paid</span></td>
          <td><span class="pill pill-{{ $o[4]==='delivered'?'green':($o[4]==='shipped'?'orange':'blue') }}">{{ ucfirst($o[4]) }}</span></td>
          <td style="color:var(--text-mid);font-size:12px;">{{ $o[5] }}</td>
          <td>
            <div style="display:flex;gap:6px;">
              <button class="btn btn-ghost btn-sm" title="View"><i class="fas fa-eye"></i></button>
              <button class="btn btn-ghost btn-sm" title="Invoice"><i class="fas fa-file-invoice"></i></button>
            </div>
          </td>
        </tr>
        @endforeach
        @endforelse
      </tbody>
    </table>
  </div>

  <!-- Pagination -->
  <div style="display:flex;align-items:center;justify-content:space-between;margin-top:18px;">
    <span style="font-size:13px;color:var(--text-mid);">Showing 1–5 of 248 orders</span>
    <div style="display:flex;gap:6px;">
      <button class="btn btn-ghost btn-sm"><i class="fas fa-chevron-left"></i></button>
      <button class="btn btn-primary btn-sm">1</button>
      <button class="btn btn-ghost btn-sm">2</button>
      <button class="btn btn-ghost btn-sm">3</button>
      <button class="btn btn-ghost btn-sm"><i class="fas fa-chevron-right"></i></button>
    </div>
  </div>
</div>
@endsection