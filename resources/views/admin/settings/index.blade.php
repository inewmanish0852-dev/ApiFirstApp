{{-- resources/views/admin/settings/index.blade.php --}}
@extends('admin.layouts.app')
@section('title','Settings') @section('page-title','Settings')
@section('content')
<div class="page-header fade-up">
  <div><div class="breadcrumb">Home / <span>Settings</span></div><h1>Settings</h1><p>Configure your app settings</p></div>
  <button class="btn btn-primary"><i class="fas fa-save"></i> Save Changes</button>
</div>

<div class="grid-2 fade-up-2">
  <!-- App Settings -->
  <div class="card">
    <div class="card-title"><i class="fas fa-mobile-alt" style="color:var(--accent)"></i> App Settings</div>
    <div style="display:flex;flex-direction:column;gap:14px;">
      @foreach([['App Name','MyApp','text'],['Support Email','support@myapp.com','email'],['Support Phone','+91 1800 123 456','tel'],['Currency Symbol','₹','text'],['Free Delivery Above (₹)','500','number']]) 
      <div>
        <label style="font-size:12px;font-weight:600;color:var(--text-mid);display:block;margin-bottom:5px;">{{ $item[0] }}</label>
        <input type="{{ $item[2] }}" value="{{ $item[1] }}" style="width:100%;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
      </div>
      @endforeach
    </div>
  </div>

  <!-- Admin Account -->
  <div>
    <div class="card" style="margin-bottom:20px;">
      <div class="card-title"><i class="fas fa-user-shield" style="color:var(--accent)"></i> Admin Account</div>
      <div style="display:flex;flex-direction:column;gap:14px;">
        @foreach([['Full Name','Admin'],['Email','admin@myapp.com'],['New Password',''],['Confirm Password','']])
        <div>
          <label style="font-size:12px;font-weight:600;color:var(--text-mid);display:block;margin-bottom:5px;">{{ $item[0] }}</label>
          <input type="{{ str_contains(strtolower($item[0]),'password')?'password':'text' }}" value="{{ $item[1] }}" placeholder="{{ str_contains(strtolower($item[0]),'password')?'••••••••':'' }}" style="width:100%;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:10px 14px;color:var(--text);font-size:13px;font-family:var(--font);outline:none;">
        </div>
        @endforeach
        <button class="btn btn-primary" style="justify-content:center;"><i class="fas fa-save"></i> Update Account</button>
      </div>
    </div>

    <div class="card">
      <div class="card-title"><i class="fas fa-toggle-on" style="color:var(--accent)"></i> Feature Toggles</div>
      @foreach([['Reviews',true],['Gallery',true],['Chat Support',true],['Push Notifications',false],['COD Payments',true]]) 
      <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--border);">
        <span style="font-size:13px;font-weight:600;color:var(--text);">{{ $item[0] }}</span>
        <label style="position:relative;width:44px;height:24px;cursor:pointer;">
          <input type="checkbox" {{ $item[1]?'checked':'' }} style="opacity:0;width:0;height:0;">
          <span style="position:absolute;inset:0;background:{{ $item[1]?'var(--accent)':'var(--navy-light)' }};border-radius:24px;transition:.3s;"></span>
          <span style="position:absolute;left:{{ $item[1]?'22':'2' }}px;top:2px;width:20px;height:20px;background:white;border-radius:50%;transition:.3s;"></span>
        </label>
      </div>
      @endforeach
    </div>
  </div>
</div>
@endsection