<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Jinemo E-CRM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="admin-layout">
        <aside class="sidebar">
            <h2 class="logo mb-2">Jinemo Admin</h2>
            <a href="/admin/dashboard" class="{{ request()->is('admin/dashboard') ? 'active' : '' }}">Dashboard</a>
            <a href="/admin/produk" class="{{ request()->is('admin/produk') ? 'active' : '' }}">Kelola Produk</a>
            <a href="/admin/pelanggan" class="{{ request()->is('admin/pelanggan') ? 'active' : '' }}">Kelola Pelanggan</a>
            <a href="/admin/pesanan" class="{{ request()->is('admin/pesanan') ? 'active' : '' }}">Kelola Pesanan</a>
            <a href="/admin/testimoni" class="{{ request()->is('admin/testimoni') ? 'active' : '' }}">Testimoni</a>
            <a href="/admin/pengaduan" class="{{ request()->is('admin/pengaduan') ? 'active' : '' }}">Pengaduan</a>
            <hr style="border-color: rgba(255,255,255,0.1); margin: 20px 0;">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="width: 100%; text-align:left; background:transparent; color:var(--text-muted); padding:10px;">Logout</button>
            </form>
        </aside>
        <main class="admin-content">
            @yield('content')
        </main>
    </div>
</body>
</html>
