<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Dashboard') — MyApp Admin</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
  <style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
      --navy:       #0F1B35;
      --navy-mid:   #162040;
      --navy-light: #1E2D52;
      --blue:       #1A3C6E;
      --accent:     #4A90D9;
      --accent-glow:#4A90D922;
      --green:      #10B981;
      --orange:     #F59E0B;
      --red:        #EF4444;
      --purple:     #8B5CF6;
      --text:       #E8EDF5;
      --text-mid:   #9BAABF;
      --text-dim:   #5A6A80;
      --border:     #1E2D52;
      --card:       #162040;
      --card-hover: #1A2649;
      --sidebar-w:  260px;
      --topbar-h:   64px;
      --radius:     14px;
      --radius-sm:  8px;
      --shadow:     0 4px 24px rgba(0,0,0,0.35);
      --font:       'Plus Jakarta Sans', sans-serif;
      --mono:       'JetBrains Mono', monospace;
    }

    html, body { height: 100%; background: var(--navy); color: var(--text); font-family: var(--font); font-size: 14px; }

    /* ── SIDEBAR ─────────────────────────────────────────────── */
    .sidebar {
      position: fixed; top: 0; left: 0; bottom: 0;
      width: var(--sidebar-w);
      background: var(--navy-mid);
      border-right: 1px solid var(--border);
      display: flex; flex-direction: column;
      z-index: 100; transition: transform .3s ease;
    }
    .sidebar-brand {
      display: flex; align-items: center; gap: 12px;
      padding: 20px 22px 16px;
      border-bottom: 1px solid var(--border);
    }
    .brand-logo {
      width: 40px; height: 40px; border-radius: 12px;
      background: linear-gradient(135deg, var(--accent), #2563EB);
      display: flex; align-items: center; justify-content: center;
      font-weight: 900; font-size: 18px; color: white;
      box-shadow: 0 0 20px var(--accent-glow);
      flex-shrink: 0;
    }
    .brand-text { line-height: 1.2; }
    .brand-text h2 { font-size: 16px; font-weight: 800; color: var(--text); }
    .brand-text span { font-size: 11px; color: var(--text-mid); font-weight: 500; letter-spacing: .5px; }

    .sidebar-nav { flex: 1; overflow-y: auto; padding: 16px 12px; scrollbar-width: none; }
    .sidebar-nav::-webkit-scrollbar { display: none; }

    .nav-section { margin-bottom: 24px; }
    .nav-section-label {
      font-size: 10px; font-weight: 700; letter-spacing: 1.5px;
      color: var(--text-dim); text-transform: uppercase;
      padding: 0 10px; margin-bottom: 6px;
    }
    .nav-item {
      display: flex; align-items: center; gap: 11px;
      padding: 10px 12px; border-radius: var(--radius-sm);
      color: var(--text-mid); text-decoration: none;
      font-weight: 600; font-size: 13.5px;
      transition: all .2s; position: relative; cursor: pointer;
      margin-bottom: 2px;
    }
    .nav-item:hover { color: var(--text); background: var(--navy-light); }
    .nav-item.active {
      color: var(--accent); background: var(--accent-glow);
      box-shadow: inset 3px 0 0 var(--accent);
    }
    .nav-item .nav-icon { width: 18px; text-align: center; font-size: 15px; flex-shrink: 0; }
    .nav-item .nav-badge {
      margin-left: auto; min-width: 20px; height: 20px;
      background: var(--red); border-radius: 10px; font-size: 10px;
      font-weight: 700; color: white; display: flex;
      align-items: center; justify-content: center; padding: 0 5px;
    }
    .nav-item .nav-badge.green { background: var(--green); }

    .sidebar-footer {
      padding: 16px; border-top: 1px solid var(--border);
    }
    .admin-card {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 12px; border-radius: var(--radius-sm);
      background: var(--navy-light);
    }
    .admin-avatar {
      width: 36px; height: 36px; border-radius: 10px;
      background: linear-gradient(135deg, var(--accent), #2563EB);
      display: flex; align-items: center; justify-content: center;
      font-weight: 800; font-size: 14px; color: white; flex-shrink: 0;
    }
    .admin-info { flex: 1; min-width: 0; }
    .admin-info h4 { font-size: 13px; font-weight: 700; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
    .admin-info span { font-size: 11px; color: var(--text-mid); }
    .admin-card a { color: var(--text-mid); font-size: 13px; text-decoration: none; transition: color .2s; }
    .admin-card a:hover { color: var(--red); }

    /* ── TOPBAR ───────────────────────────────────────────────── */
    .topbar {
      position: fixed; top: 0; left: var(--sidebar-w); right: 0;
      height: var(--topbar-h);
      background: var(--navy-mid);
      border-bottom: 1px solid var(--border);
      display: flex; align-items: center;
      padding: 0 28px; gap: 16px; z-index: 99;
    }
    .topbar-title { font-size: 18px; font-weight: 800; color: var(--text); flex: 1; }
    .topbar-title span { color: var(--accent); }

    .topbar-search {
      display: flex; align-items: center; gap: 8px;
      background: var(--navy-light); border: 1px solid var(--border);
      border-radius: 10px; padding: 8px 14px; width: 240px;
    }
    .topbar-search i { color: var(--text-dim); font-size: 13px; }
    .topbar-search input { background: none; border: none; outline: none; color: var(--text); font-size: 13px; font-family: var(--font); width: 100%; }
    .topbar-search input::placeholder { color: var(--text-dim); }

    .topbar-btn {
      width: 40px; height: 40px; border-radius: 10px;
      background: var(--navy-light); border: 1px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      color: var(--text-mid); cursor: pointer; position: relative;
      text-decoration: none; transition: all .2s;
    }
    .topbar-btn:hover { color: var(--text); border-color: var(--accent); }
    .topbar-notif-dot {
      position: absolute; top: 7px; right: 7px;
      width: 8px; height: 8px; background: var(--red); border-radius: 50%;
      border: 2px solid var(--navy-mid);
    }

    /* ── MAIN CONTENT ─────────────────────────────────────────── */
    .main-wrap {
      margin-left: var(--sidebar-w);
      padding-top: var(--topbar-h);
      min-height: 100vh;
    }
    .main-content { padding: 28px; }

    /* ── CARDS ────────────────────────────────────────────────── */
    .card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 22px;
      transition: border-color .2s;
    }
    .card:hover { border-color: #2A3A60; }
    .card-title {
      font-size: 15px; font-weight: 700; color: var(--text);
      margin-bottom: 18px; display: flex; align-items: center;
      justify-content: space-between; gap: 8px;
    }
    .card-title .badge {
      font-size: 11px; padding: 3px 10px; border-radius: 20px; font-weight: 600;
    }

    /* ── STAT CARDS ───────────────────────────────────────────── */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 24px; }
    .stat-card {
      background: var(--card); border: 1px solid var(--border);
      border-radius: var(--radius); padding: 20px 22px;
      position: relative; overflow: hidden; transition: all .25s;
    }
    .stat-card:hover { transform: translateY(-2px); border-color: var(--accent); box-shadow: var(--shadow); }
    .stat-card::before {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(135deg, var(--accent-glow), transparent);
      opacity: 0; transition: opacity .3s;
    }
    .stat-card:hover::before { opacity: 1; }
    .stat-icon {
      width: 44px; height: 44px; border-radius: 12px;
      display: flex; align-items: center; justify-content: center;
      font-size: 20px; margin-bottom: 14px;
    }
    .stat-label { font-size: 12px; font-weight: 600; color: var(--text-mid); text-transform: uppercase; letter-spacing: .8px; margin-bottom: 6px; }
    .stat-value { font-size: 28px; font-weight: 800; color: var(--text); line-height: 1; margin-bottom: 8px; }
    .stat-trend { font-size: 12px; font-weight: 600; display: flex; align-items: center; gap: 4px; }
    .stat-trend.up { color: var(--green); }
    .stat-trend.down { color: var(--red); }

    /* ── TABLE ────────────────────────────────────────────────── */
    .table-wrap { overflow-x: auto; }
    table { width: 100%; border-collapse: collapse; }
    thead th {
      background: var(--navy-light); color: var(--text-mid);
      font-size: 11px; font-weight: 700; text-transform: uppercase;
      letter-spacing: 1px; padding: 12px 16px; text-align: left;
      white-space: nowrap;
    }
    thead th:first-child { border-radius: var(--radius-sm) 0 0 var(--radius-sm); }
    thead th:last-child  { border-radius: 0 var(--radius-sm) var(--radius-sm) 0; }
    tbody tr {
      border-bottom: 1px solid var(--border);
      transition: background .15s;
    }
    tbody tr:hover { background: var(--card-hover); }
    tbody tr:last-child { border-bottom: none; }
    td { padding: 14px 16px; color: var(--text); font-size: 13.5px; vertical-align: middle; }

    /* ── BADGES / PILLS ───────────────────────────────────────── */
    .pill {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 4px 10px; border-radius: 20px;
      font-size: 11px; font-weight: 700;
    }
    .pill-green   { background: #10B98120; color: var(--green); }
    .pill-orange  { background: #F59E0B20; color: var(--orange); }
    .pill-blue    { background: #4A90D920; color: var(--accent); }
    .pill-red     { background: #EF444420; color: var(--red); }
    .pill-purple  { background: #8B5CF620; color: var(--purple); }
    .pill::before { content: ''; width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* ── BUTTONS ──────────────────────────────────────────────── */
    .btn {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 9px 18px; border-radius: var(--radius-sm);
      font-size: 13px; font-weight: 600; cursor: pointer;
      border: none; text-decoration: none; transition: all .2s; font-family: var(--font);
    }
    .btn-primary { background: var(--accent); color: white; }
    .btn-primary:hover { background: #3A80C9; box-shadow: 0 4px 15px #4A90D940; }
    .btn-ghost { background: var(--navy-light); color: var(--text-mid); border: 1px solid var(--border); }
    .btn-ghost:hover { color: var(--text); border-color: var(--accent); }
    .btn-danger { background: #EF444420; color: var(--red); border: 1px solid #EF444430; }
    .btn-danger:hover { background: var(--red); color: white; }
    .btn-sm { padding: 6px 12px; font-size: 12px; }

    /* ── GRID HELPERS ─────────────────────────────────────────── */
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    .grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; }

    /* ── PAGE HEADER ──────────────────────────────────────────── */
    .page-header {
      display: flex; align-items: center; justify-content: space-between;
      margin-bottom: 24px;
    }
    .page-header h1 { font-size: 22px; font-weight: 800; color: var(--text); }
    .page-header p  { font-size: 13px; color: var(--text-mid); margin-top: 3px; }
    .breadcrumb { font-size: 12px; color: var(--text-dim); margin-bottom: 4px; }
    .breadcrumb span { color: var(--accent); }

    /* ── SCROLLBAR ────────────────────────────────────────────── */
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 10px; }

    /* ── ANIMATIONS ───────────────────────────────────────────── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .4s ease forwards; }
    .fade-up-2 { animation: fadeUp .4s .1s ease both; }
    .fade-up-3 { animation: fadeUp .4s .2s ease both; }
    .fade-up-4 { animation: fadeUp .4s .3s ease both; }

    /* ── SIDEBAR TOGGLE (mobile) ──────────────────────────────── */
    .sidebar-toggle { display: none; }
    @media (max-width: 1024px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
      .main-wrap { margin-left: 0; }
      .topbar { left: 0; }
      .sidebar-toggle { display: flex; }
      .stats-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
      .stats-grid { grid-template-columns: 1fr; }
      .grid-2, .grid-3 { grid-template-columns: 1fr; }
    }
  </style>
  @stack('styles')
</head>
<body>

<!-- ── SIDEBAR ────────────────────────────────────────────────────────── -->
<aside class="sidebar" id="sidebar">
  <div class="sidebar-brand">
    <div class="brand-logo">M</div>
    <div class="brand-text">
      <h2>MyApp</h2>
      <span>Admin Panel</span>
    </div>
  </div>

  <nav class="sidebar-nav">
    <div class="nav-section">
      <div class="nav-section-label">Overview</div>
      <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-chart-line"></i></span> Dashboard
      </a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Catalogue</div>
      <a href="{{ route('admin.products.index') }}" class="nav-item {{ request()->routeIs('admin.products*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-box"></i></span> Products
      </a>
      <a href="{{ route('admin.orders.index') }}" class="nav-item {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-receipt"></i></span> Orders
        <span class="nav-badge">3</span>
      </a>
      <a href="{{ route('admin.reviews.index') }}" class="nav-item {{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-star"></i></span> Reviews
      </a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Users & Support</div>
      <a href="{{ route('admin.users.index') }}" class="nav-item {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-users"></i></span> Users
      </a>
      <a href="{{ route('admin.chat.index') }}" class="nav-item {{ request()->routeIs('admin.chat*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-comments"></i></span> Chat / Support
        <span class="nav-badge green">2</span>
      </a>
      <a href="{{ route('admin.notifications.index') }}" class="nav-item {{ request()->routeIs('admin.notifications*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-bell"></i></span> Notifications
      </a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">Content</div>
      <a href="{{ route('admin.gallery.index') }}" class="nav-item {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-images"></i></span> Gallery
      </a>
    </div>

    <div class="nav-section">
      <div class="nav-section-label">System</div>
      <a href="{{ route('admin.settings') }}" class="nav-item {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
        <span class="nav-icon"><i class="fas fa-cog"></i></span> Settings
      </a>
    </div>
  </nav>

  <div class="sidebar-footer">
    <div class="admin-card">
      <div class="admin-avatar">A</div>
      <div class="admin-info">
        <h4>Admin</h4>
        <span>Super Admin</span>
      </div>
      <a href="{{ route('admin.logout') }}" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="fas fa-sign-out-alt"></i>
      </a>
    </div>
  </div>
</aside>

<form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none">@csrf</form>

<!-- ── TOPBAR ─────────────────────────────────────────────────────────── -->
<div class="topbar">
  <button class="topbar-btn sidebar-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
    <i class="fas fa-bars"></i>
  </button>
  <h1 class="topbar-title">@yield('page-title', 'Dashboard') <span>/ MyApp</span></h1>

  <div class="topbar-search">
    <i class="fas fa-search"></i>
    <input type="text" placeholder="Search orders, users…">
  </div>

  <a href="{{ route('admin.notifications.index') }}" class="topbar-btn">
    <i class="fas fa-bell"></i>
    <span class="topbar-notif-dot"></span>
  </a>

  <a href="{{ route('admin.settings') }}" class="topbar-btn">
    <i class="fas fa-cog"></i>
  </a>
</div>

<!-- ── MAIN ───────────────────────────────────────────────────────────── -->
<div class="main-wrap">
  <div class="main-content">
    @if(session('success'))
      <div style="background:#10B98120;border:1px solid #10B98140;color:#10B981;padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div style="background:#EF444420;border:1px solid #EF444440;color:#EF4444;padding:12px 18px;border-radius:10px;margin-bottom:20px;font-size:13px;font-weight:600;display:flex;align-items:center;gap:8px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
      </div>
    @endif
    @yield('content')
  </div>
</div>

@stack('scripts')
</body>
</html>