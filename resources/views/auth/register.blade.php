@extends('layouts.app')

@section('content')
<div style="max-width: 500px; margin: 60px auto;">
    <h2 class="text-center mb-2">Buat Akun Pelanggan Baru</h2>
    <div class="card">
        <form method="POST" action="/register">
            @csrf
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required minlength="8">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input type="password" name="password_confirmation" class="form-control" required minlength="8">
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Register & Klaim Promo</button>
        </form>
        <p class="text-center mt-2" style="color: var(--text-muted);">Sudah punya akun? <a href="/login">Login di sini</a></p>
    </div>
</div>
@endsection
