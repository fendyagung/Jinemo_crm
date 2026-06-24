<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jinemo E-CRM</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a href="/" class="logo">Jinemo.</a>
            <div class="nav-links">
                <a href="/">Home</a>
                <a href="/produk">Menu</a>
                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="/admin/dashboard" class="btn btn-primary">Admin Panel</a>
                    @else
                        <a href="/riwayat">Riwayat</a>
                        <a href="/testimoni">Testimoni</a>
                        <a href="/pengaduan">Pengaduan</a>
                        <a href="/profil" class="btn btn-primary" style="background:transparent; border: 1px solid var(--primary); color: var(--primary);">Poin: {{ auth()->user()->point }}</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn" style="background:transparent; color:var(--text-muted);">Logout</button>
                    </form>
                @else
                    <a href="/login" class="btn">Login</a>
                    <a href="/register" class="btn btn-primary">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    <main style="min-height: 80vh; padding-top: 40px;" class="container">
        @yield('content')
    </main>
</body>
</html>
