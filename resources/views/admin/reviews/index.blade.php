{{-- resources/views/admin/reviews/index.blade.php --}}
@extends('admin.layouts.app')
@section('title','Reviews') @section('page-title','Reviews')
@section('content')
<div class="page-header fade-up">
  <div><div class="breadcrumb">Home / <span>Reviews</span></div><h1>Product Reviews</h1><p>Monitor and manage customer reviews</p></div>
</div>
<div class="card fade-up-2">
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>User</th><th>Product</th><th>Rating</th><th>Review</th><th>Date</th><th>Actions</th></tr></thead>
      <tbody>
        @foreach([
          [1,'John D.','Wireless Headphones',5,'Amazing sound quality! Worth every rupee.','Jan 10'],
          [2,'Alice S.','Smartphone Pro Max',4,'Great camera, slight heating issue.','Jan 8'],
          [3,'Bob K.','Smart Watch',5,'Best smartwatch I have used.','Jan 6'],
          [4,'Priya M.','Premium T-Shirt',3,'Good quality but delivery was late.','Jan 5'],
          [5,'Ravi T.','Leather Backpack',4,'Very sturdy and spacious.','Jan 3'],
        ] as $r)
        <tr>
          <td style="color:var(--text-dim);font-size:12px;">{{ $r[0] }}</td>
          <td><div style="display:flex;align-items:center;gap:8px;"><div style="width:30px;height:30px;border-radius:8px;background:var(--accent);opacity:.8;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:11px;">{{ substr($r[1],0,1) }}</div>{{ $r[1] }}</div></td>
          <td style="color:var(--text-mid);">{{ $r[2] }}</td>
          <td><span style="color:#F59E0B;">{{ str_repeat('★',$r[3]) }}{{ str_repeat('☆',5-$r[3]) }}</span></td>
          <td style="color:var(--text-mid);font-size:12px;max-width:220px;">{{ $r[4] }}</td>
          <td style="color:var(--text-dim);font-size:12px;">{{ $r[5] }}</td>
          <td><button class="btn btn-danger btn-sm" title="Delete"><i class="fas fa-trash"></i></button></td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@endsection