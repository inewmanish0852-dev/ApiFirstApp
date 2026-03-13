{{-- resources/views/admin/gallery/index.blade.php --}}
@extends('admin.layouts.app')
@section('title','Gallery') @section('page-title','Gallery')
@section('content')
<div class="page-header fade-up">
  <div><div class="breadcrumb">Home / <span>Gallery</span></div><h1>Gallery</h1><p>Manage app images</p></div>
  <button class="btn btn-primary"><i class="fas fa-upload"></i> Upload Image</button>
</div>
<div class="card fade-up-2">
  <div style="display:flex;gap:10px;margin-bottom:20px;">
    @foreach(['All','Products','Team'] as $tab)
    <button class="btn {{ $loop->first ? 'btn-primary' : 'btn-ghost' }}" style="padding:7px 18px;font-size:13px;">{{ $tab }}</button>
    @endforeach
  </div>
  <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(140px,1fr));gap:12px;">
    @foreach(['🎧 Headphones','👕 T-Shirt','📱 Smartphone','🎒 Backpack','⌚ SmartWatch','🏢 Office','👥 Team','🏭 Warehouse'] as $i => $g)
    <div style="position:relative;aspect-ratio:1;background:var(--navy-light);border-radius:12px;display:flex;flex-direction:column;align-items:center;justify-content:center;border:1px solid var(--border);overflow:hidden;cursor:pointer;transition:border-color .2s;" onmouseover="this.style.borderColor='var(--accent)'" onmouseout="this.style.borderColor='var(--border)'">
      <div style="font-size:36px;margin-bottom:6px;">{{ explode(' ',$g)[0] }}</div>
      <div style="font-size:11px;color:var(--text-mid);text-align:center;padding:0 6px;">{{ explode(' ',$g,2)[1] }}</div>
      <div style="position:absolute;top:6px;right:6px;display:flex;gap:4px;">
        <button class="btn btn-danger btn-sm" style="padding:4px 6px;font-size:10px;"><i class="fas fa-trash"></i></button>
      </div>
    </div>
    @endforeach
  </div>
</div>
@endsection