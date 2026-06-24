@extends('layouts.app')

@section('content')
<style>
.auth-wrap {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 40px 16px;
}
.auth-card {
    width: 100%;
    max-width: 440px;
    background: var(--card-bg);
    border-radius: 24px;
    border: 1px solid rgba(255,255,255,0.08);
    overflow: hidden;
    box-shadow: 0 24px 60px rgba(0,0,0,0.4);
}
.auth-header {
    padding: 36px 36px 28px;
    text-align: center;
    background: linear-gradient(135deg, rgba(240,165,0,0.08), transparent);
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.auth-logo {
    font-size: 2.4rem;
    font-weight: 900;
    color: var(--primary);
    letter-spacing: -1px;
    margin-bottom: 6px;
}
.auth-logo span { color: var(--text-light); }
.auth-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 4px; }
.auth-sub   { color: var(--text-muted); font-size: 0.85rem; }
.auth-body  { padding: 32px 36px; }
.form-label { display:block; font-size:0.8rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:8px; }
.form-input {
    width: 100%;
    padding: 13px 16px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.04);
    color: var(--text-light);
    font-size: 0.95rem;
    transition: 0.2s;
    font-family: inherit;
}
.form-input:focus {
    outline: none;
    border-color: var(--primary);
    background: rgba(240,165,0,0.04);
    box-shadow: 0 0 0 3px rgba(240,165,0,0.08);
}
.form-input::placeholder { color: rgba(255,255,255,0.25); }
.mb-18 { margin-bottom: 18px; }
.btn-login {
    width: 100%;
    padding: 14px;
    background: var(--primary);
    color: #1a1a1a;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 8px;
}
.btn-login:hover {
    background: var(--primary-dark, #cf8d00);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(240,165,0,0.3);
}
.auth-footer {
    text-align: center;
    margin-top: 20px;
    color: var(--text-muted);
    font-size: 0.88rem;
}
.auth-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
.auth-footer a:hover { text-decoration: underline; }
.alert-error {
    background: rgba(239,68,68,0.1);
    border: 1px solid rgba(239,68,68,0.3);
    color: #ef4444;
    padding: 12px 16px;
    border-radius: 10px;
    margin-bottom: 20px;
    font-size: 0.88rem;
}
</style>

<div class="auth-wrap">
    <div class="auth-card">
        <div class="auth-header">
            <div class="auth-logo">Jine<span>mo</span></div>
            <div class="auth-title">Masuk ke Akun Anda</div>
            <div class="auth-sub">Selamat datang kembali! Silakan login untuk melanjutkan.</div>
        </div>
        <div class="auth-body">

            {{-- Error --}}
            @if($errors->any())
            <div class="alert-error">
                ✕ {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="mb-18">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-input"
                        placeholder="contoh@email.com" required value="{{ old('email') }}">
                </div>
                <div class="mb-18">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-input"
                        placeholder="••••••••" required>
                </div>
                <button type="submit" class="btn-login">🔐 Masuk Sekarang</button>
            </form>

            <div class="auth-footer">
                Belum punya akun? <a href="/register">Daftar di sini</a>
            </div>
        </div>
    </div>
</div>
@endsection
