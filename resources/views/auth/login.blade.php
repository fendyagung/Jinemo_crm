@extends('layouts.app')

@section('content')
<div style="max-width: 400px; margin: 60px auto;">
    <h2 class="text-center mb-2">Login ke Jinemo</h2>
    <div class="card">
        <form method="POST" action="/login">
            @csrf
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </form>
        <p class="text-center mt-2" style="color: var(--text-muted);">Belum punya akun? <a href="/register">Daftar sekarang</a></p>
    </div>
</div>
@endsection
