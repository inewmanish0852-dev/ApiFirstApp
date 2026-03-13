{{-- resources/views/admin/chat/index.blade.php --}}
@extends('admin.layouts.app')
@section('title','Chat') @section('page-title','Chat / Support')
@section('content')
<div class="page-header fade-up">
  <div><div class="breadcrumb">Home / <span>Chat</span></div><h1>Chat & Support</h1><p>All user conversations</p></div>
</div>
<div style="display:grid;grid-template-columns:300px 1fr;gap:20px;height:calc(100vh - 220px);" class="fade-up-2">
  <!-- Conversation List -->
  <div class="card" style="overflow-y:auto;padding:16px;">
    <div style="font-size:13px;font-weight:700;color:var(--text-mid);margin-bottom:12px;text-transform:uppercase;letter-spacing:.8px;">Conversations</div>
    @foreach([
      ['Rahul Kumar','Your order has been shipped!',2,true,'2 min'],
      ['Priya Sharma','Thank you for your help!',0,false,'1 hr'],
      ['Amit Mehta','When will my order arrive?',1,true,'3 hr'],
      ['Sneha Rao','Can I return this product?',0,false,'1 day'],
    ] as $c)
    <div style="display:flex;align-items:center;gap:10px;padding:10px;border-radius:10px;cursor:pointer;margin-bottom:4px;background:{{ $loop->first?'var(--accent-glow)':'transparent' }};border:1px solid {{ $loop->first?'var(--accent)':'transparent' }};">
      <div style="width:38px;height:38px;border-radius:12px;background:var(--accent);opacity:.8;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;flex-shrink:0;position:relative;">
        {{ substr($c[0],0,1) }}
        @if($c[3])<div style="position:absolute;bottom:0;right:0;width:10px;height:10px;background:#10B981;border-radius:50%;border:2px solid var(--card);"></div>@endif
      </div>
      <div style="flex:1;min-width:0;">
        <div style="display:flex;justify-content:space-between;"><span style="font-size:13px;font-weight:700;color:var(--text);">{{ $c[0] }}</span><span style="font-size:10px;color:var(--text-dim);">{{ $c[4] }}</span></div>
        <div style="font-size:11px;color:var(--text-mid);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $c[1] }}</div>
      </div>
      @if($c[2]>0)<div style="min-width:18px;height:18px;background:var(--red);border-radius:9px;font-size:10px;font-weight:700;color:white;display:flex;align-items:center;justify-content:center;padding:0 4px;">{{ $c[2] }}</div>@endif
    </div>
    @endforeach
  </div>

  <!-- Chat Window -->
  <div class="card" style="display:flex;flex-direction:column;padding:0;overflow:hidden;">
    <!-- Chat Header -->
    <div style="padding:16px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:12px;">
      <div style="width:38px;height:38px;border-radius:12px;background:var(--accent);opacity:.8;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:14px;">R</div>
      <div><div style="font-size:14px;font-weight:700;color:var(--text);">Rahul Kumar</div><div style="font-size:11px;color:#10B981;">● Online</div></div>
    </div>
    <!-- Messages -->
    <div style="flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:12px;">
      @foreach([
        ['user','Hello! What is the status of my order ORD-2024-002?','2:30 PM'],
        ['admin','Hi Rahul! Your order ORD-2024-002 has been shipped. Tracking ID: TRK123456.','2:32 PM'],
        ['user','Thank you! When will it be delivered?','2:33 PM'],
        ['admin','Expected delivery is January 18th. You will receive an SMS update.','2:34 PM'],
      ] as $m)
      <div style="display:flex;{{ $m[0]==='admin'?'justify-content:flex-end;':'' }}">
        <div style="max-width:65%;background:{{ $m[0]==='admin'?'var(--accent)':'var(--navy-light)' }};border-radius:{{ $m[0]==='admin'?'16px 16px 4px 16px':'16px 16px 16px 4px' }};padding:10px 14px;">
          <div style="font-size:13px;color:white;line-height:1.5;">{{ $m[1] }}</div>
          <div style="font-size:10px;color:rgba(255,255,255,.5);margin-top:4px;text-align:right;">{{ $m[2] }}</div>
        </div>
      </div>
      @endforeach
    </div>
    <!-- Input -->
    <div style="padding:16px 20px;border-top:1px solid var(--border);display:flex;gap:10px;">
      <input type="text" placeholder="Type a reply…" style="flex:1;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
      <button class="btn btn-primary"><i class="fas fa-paper-plane"></i> Send</button>
    </div>
  </div>
</div>
@endsection