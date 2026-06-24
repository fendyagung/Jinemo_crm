<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Jinemo E-CRM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <style>
        .admin-topbar { display:flex; justify-content:flex-end; align-items:center; gap:12px; padding:12px 32px; border-bottom:1px solid rgba(255,255,255,0.06); background:var(--card-bg); }
        .admin-topbar-name { font-size:0.88rem; color:var(--text-muted); }
        .admin-topbar-link { display:flex; align-items:center; gap:8px; text-decoration:none; }
        .topbar-avatar { width:34px; height:34px; border-radius:50%; overflow:hidden; background:linear-gradient(135deg,#f0a500,#cf8d00); display:flex; align-items:center; justify-content:center; font-weight:700; color:#1a1a1a; font-size:0.88rem; flex-shrink:0; }
        .topbar-avatar img { width:100%; height:100%; object-fit:cover; }
    </style>
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2 class="logo mb-2">Jinemo Admin</h2>
            <a href="/admin/dashboard"  class="{{ request()->is('admin/dashboard')  ? 'active' : '' }}">📊 Dashboard</a>
            <a href="/admin/produk"     class="{{ request()->is('admin/produk')     ? 'active' : '' }}">🍽️ Kelola Produk</a>
            <a href="/admin/pelanggan"  class="{{ request()->is('admin/pelanggan')  ? 'active' : '' }}">👥 Kelola Pelanggan</a>
            <a href="/admin/pesanan"    class="{{ request()->is('admin/pesanan')    ? 'active' : '' }}">📦 Kelola Pesanan</a>
            <a href="/admin/laporan"    class="{{ request()->is('admin/laporan')    ? 'active' : '' }}">📈 Laporan</a>
            <a href="/admin/testimoni"  class="{{ request()->is('admin/testimoni')  ? 'active' : '' }}">⭐ Testimoni</a>
            <a href="/admin/pengaduan"  class="{{ request()->is('admin/pengaduan')  ? 'active' : '' }}">📢 Pengaduan</a>
            <a href="/admin/profil"     class="{{ request()->is('admin/profil')     ? 'active' : '' }}">👤 Profil Saya</a>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="width: 100%; text-align:left; background:transparent; color:var(--text-muted); padding:10px;">🚪 Logout</button>
            </form>
        </aside>
        <div style="flex:1; display:flex; flex-direction:column;">
            <div class="admin-topbar">
                <span class="admin-topbar-name">Halo, <strong>{{ auth()->user()->name }}</strong></span>
                <a href="/admin/profil" class="admin-topbar-link">
                    <div class="topbar-avatar">
                        @if(auth()->user()->foto)
                            <img src="{{ Storage::url(auth()->user()->foto) }}" alt="">
                        @else
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        @endif
                    </div>
                </a>
            </div>
            <main class="admin-content">
                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
