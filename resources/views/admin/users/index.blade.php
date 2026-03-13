{{-- resources/views/admin/users/index.blade.php --}}
@extends('admin.layouts.app')
@section('title', 'Users')
@section('page-title', 'Users')
@section('content')
<div class="page-header fade-up">
  <div>
    <div class="breadcrumb">Home / <span>Users</span></div>
    <h1>Users</h1>
    <p>All registered app users</p>
  </div>
  <button class="btn btn-primary"><i class="fas fa-download"></i> Export</button>
</div>

<div class="card fade-up-2">
  <div style="display:flex;gap:12px;margin-bottom:20px;">
    <div style="flex:1;display:flex;align-items:center;gap:8px;background:var(--navy-light);border:1px solid var(--border);border-radius:10px;padding:9px 14px;">
      <i class="fas fa-search" style="color:var(--text-dim);font-size:13px;"></i>
      <input type="text" placeholder="Search users…" style="background:none;border:none;outline:none;color:var(--text);font-size:13px;font-family:var(--font);width:100%;">
    </div>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>#</th><th>User</th><th>Email</th><th>Phone</th><th>Orders</th><th>Joined</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($users ?? [] as $u)
        <tr>
          <td style="color:var(--text-dim);font-size:12px;">{{ $u->id }}</td>
          <td><div style="display:flex;align-items:center;gap:8px;"><div style="width:32px;height:32px;border-radius:10px;background:var(--accent);opacity:.8;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;">{{ substr($u->name,0,1) }}</div>{{ $u->name }}</div></td>
          <td style="color:var(--text-mid);">{{ $u->email }}</td>
          <td style="color:var(--text-mid);">{{ $u->phone ?? '—' }}</td>
          <td>{{ $u->orders_count ?? 0 }}</td>
          <td style="color:var(--text-mid);font-size:12px;">{{ $u->created_at->format('d M Y') }}</td>
          <td><button class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></button></td>
        </tr>
        @empty
        @foreach([['1','Rahul Kumar','rahul@email.com','+91 98765 43210',3,'10 Jan'],['2','Priya Sharma','priya@email.com','+91 91234 56789',1,'12 Jan'],['3','Amit Mehta','amit@email.com','+91 87654 32109',2,'14 Jan'],['4','Sneha Rao','sneha@email.com','+91 76543 21098',1,'15 Jan']] as $u)
        <tr>
          <td style="color:var(--text-dim);font-size:12px;">{{ $u[0] }}</td>
          <td><div style="display:flex;align-items:center;gap:8px;"><div style="width:32px;height:32px;border-radius:10px;background:var(--accent);opacity:.8;display:flex;align-items:center;justify-content:center;font-weight:800;font-size:12px;">{{ substr($u[1],0,1) }}</div>{{ $u[1] }}</div></td>
          <td style="color:var(--text-mid);">{{ $u[2] }}</td>
          <td style="color:var(--text-mid);">{{ $u[3] }}</td>
          <td>{{ $u[4] }}</td>
          <td style="color:var(--text-mid);font-size:12px;">{{ $u[5] }}</td>
          <td><button class="btn btn-ghost btn-sm"><i class="fas fa-eye"></i></button></td>
        </tr>
        @endforeach
        @endforelse
      </tbody>
    </table>
  </div>
</div>
@endsection