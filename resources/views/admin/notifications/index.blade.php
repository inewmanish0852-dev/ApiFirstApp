{{-- resources/views/admin/notifications/index.blade.php --}}
@extends('admin.layouts.app')
@section('title','Notifications') @section('page-title','Notifications')
@section('content')
<div class="page-header fade-up">
  <div><div class="breadcrumb">Home / <span>Notifications</span></div><h1>Notifications</h1><p>Send and manage push notifications</p></div>
  <button class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send Notification</button>
</div>

<div class="grid-2 fade-up-2">
  <!-- Send Form -->
  <div class="card">
    <div class="card-title">Send New Notification</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
      <div>
        <label style="font-size:12px;font-weight:600;color:var(--text-mid);display:block;margin-bottom:6px;">Title</label>
        <input type="text" placeholder="e.g. Special Offer!" style="width:100%;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:var(--text-mid);display:block;margin-bottom:6px;">Message</label>
        <textarea placeholder="Notification body…" rows="3" style="width:100%;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;resize:vertical;"></textarea>
      </div>
      <div>
        <label style="font-size:12px;font-weight:600;color:var(--text-mid);display:block;margin-bottom:6px;">Send To</label>
        <select style="width:100%;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
          <option>All Users</option>
          <option>Active Users</option>
          <option>Specific User</option>
        </select>
      </div>
      <button class="btn btn-primary" style="width:100%;justify-content:center;"><i class="fas fa-paper-plane"></i> Send Now</button>
    </div>
  </div>

  <!-- Recent Notifications -->
  <div class="card">
    <div class="card-title">Recent Sent</div>
    @foreach([
      ['📦','Order Shipped!','Your order ORD-002 is on its way.','2 min ago',false,'order'],
      ['💬','New Message','Support Team replied.','15 min ago',false,'chat'],
      ['🎉','Order Confirmed!','Order ORD-003 placed.','1 hr ago',true,'order'],
      ['⭐','Rate Purchase','How was Wireless Headphones?','1 day ago',true,'review'],
      ['🎁','Special Offer!','30% off Electronics today!','2 days ago',true,'promo'],
    ] as $n)
    <div style="display:flex;align-items:flex-start;gap:12px;padding:12px 0;border-bottom:1px solid var(--border);">
      <div style="width:40px;height:40px;border-radius:12px;background:var(--navy-light);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;">{{ $n[0] }}</div>
      <div style="flex:1;">
        <div style="font-size:13px;font-weight:{{ $n[3]?'700':'600' }};color:var(--text);">{{ $n[1] }}</div>
        <div style="font-size:12px;color:var(--text-mid);">{{ $n[2] }}</div>
        <div style="font-size:11px;color:var(--text-dim);margin-top:2px;">{{ $n[3] }}</div>
      </div>
      @if(!$n[4])<div style="width:8px;height:8px;background:var(--accent);border-radius:50%;margin-top:4px;flex-shrink:0;"></div>@endif
    </div>
    @endforeach
  </div>
</div>
@endsection


{{-- ─────────────────────────────────────────────────────────────────── --}}
{{-- resources/views/admin/settings/index.blade.php                     --}}
{{-- ─────────────────────────────────────────────────────────────────── --}}