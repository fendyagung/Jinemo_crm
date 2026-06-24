@extends('layouts.app')

@section('content')
<style>
/* Hero Section */
.hero-section {
    position: relative;
    padding: 100px 20px;
    margin: -20px -20px 40px -20px;
    background: linear-gradient(135deg, rgba(20,20,20,0.95), rgba(10,10,10,0.98)), url('https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
    border-radius: 0 0 30px 30px;
    text-align: center;
    border-bottom: 2px solid rgba(240,165,0,0.2);
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    overflow: hidden;
}
.hero-content {
    position: relative;
    z-index: 2;
    max-width: 800px;
    margin: 0 auto;
}
.hero-title {
    font-size: 3.5rem;
    font-weight: 900;
    color: #fff;
    margin-bottom: 20px;
    line-height: 1.2;
    text-shadow: 0 4px 10px rgba(0,0,0,0.5);
}
.hero-title span {
    background: linear-gradient(135deg, #f0a500, #ffc107);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.hero-subtitle {
    font-size: 1.2rem;
    color: rgba(255,255,255,0.85);
    margin-bottom: 35px;
    line-height: 1.6;
}
.hero-btns {
    display: flex;
    gap: 15px;
    justify-content: center;
}
.btn-hero-primary {
    background: linear-gradient(135deg, #f0a500, #cf8d00);
    color: #1a1a1a;
    padding: 15px 35px;
    border-radius: 50px;
    font-weight: 800;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s;
    border: none;
    box-shadow: 0 8px 20px rgba(240,165,0,0.4);
}
.btn-hero-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 25px rgba(240,165,0,0.6);
}
.btn-hero-secondary {
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.2);
    color: #fff;
    padding: 15px 35px;
    border-radius: 50px;
    font-weight: 700;
    font-size: 1.1rem;
    text-decoration: none;
    transition: all 0.3s;
}
.btn-hero-secondary:hover {
    background: rgba(255,255,255,0.2);
    transform: translateY(-3px);
}

/* Promo Banner */
.promo-banner {
    background: linear-gradient(135deg, rgba(240,165,0,0.15), rgba(207,141,0,0.05));
    border: 1px solid rgba(240,165,0,0.3);
    border-radius: 20px;
    padding: 30px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 50px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    position: relative;
    overflow: hidden;
}
.promo-banner::after {
    content: '🎉';
    position: absolute;
    right: -20px;
    top: -30px;
    font-size: 150px;
    opacity: 0.1;
}
.promo-text h3 {
    font-size: 1.6rem;
    color: var(--primary);
    margin-bottom: 10px;
    font-weight: 800;
}
.promo-text p {
    color: var(--text-muted);
    font-size: 1rem;
    max-width: 600px;
}

/* Product Cards Grid */
.section-title {
    font-size: 2rem;
    font-weight: 800;
    margin-bottom: 30px;
    display: flex;
    align-items: center;
    gap: 12px;
}
.section-title::before {
    content: '';
    display: inline-block;
    width: 6px;
    height: 30px;
    background: var(--primary);
    border-radius: 10px;
}
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}
.prod-card {
    background: var(--card-bg);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.05);
    overflow: hidden;
    transition: all 0.3s;
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
    display: flex;
    flex-direction: column;
}
.prod-card:hover {
    transform: translateY(-8px);
    border-color: rgba(240,165,0,0.3);
    box-shadow: 0 15px 30px rgba(240,165,0,0.2);
}
.prod-img {
    height: 200px;
    background-color: rgba(255,255,255,0.02);
    background-size: cover;
    background-position: center;
    position: relative;
}
.prod-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: rgba(0,0,0,0.7);
    backdrop-filter: blur(5px);
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 700;
    color: var(--primary);
    border: 1px solid rgba(240,165,0,0.3);
}
.prod-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.prod-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--text-light);
}
.prod-price {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--primary);
    margin-bottom: 20px;
}
.prod-btn {
    margin-top: auto;
    width: 100%;
    padding: 12px;
    text-align: center;
    background: rgba(240,165,0,0.1);
    color: var(--primary);
    border: 1px solid rgba(240,165,0,0.2);
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.3s;
}
.prod-card:hover .prod-btn {
    background: var(--primary);
    color: #1a1a1a;
}

/* Features */
.features-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
    margin: 60px 0;
}
.feature-card {
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.05);
    border-radius: 20px;
    padding: 30px 20px;
    text-align: center;
    transition: 0.3s;
}
.feature-card:hover {
    background: rgba(255,255,255,0.04);
    transform: translateY(-5px);
}
.feature-icon {
    font-size: 40px;
    margin-bottom: 15px;
}
.feature-title { font-size: 1.1rem; font-weight: 700; margin-bottom: 10px; }
.feature-desc { font-size: 0.9rem; color: var(--text-muted); line-height: 1.5; }

@media (max-width: 768px) {
    .hero-title { font-size: 2.2rem; }
    .promo-banner { flex-direction: column; text-align: center; gap: 20px; }
    .features-grid { grid-template-columns: 1fr; }
}
</style>

{{-- Hero Section --}}
<div class="hero-section">
    <div class="hero-content">
        <h1 class="hero-title">Eksplorasi Kekayaan <span>Cita Rasa Nusantara</span></h1>
        <p class="hero-subtitle">
            Rasakan kelezatan otentik masakan tradisional Indonesia Timur yang disajikan dengan bahan pilihan dan resep warisan leluhur.
        </p>
        <div class="hero-btns">
            <a href="/produk" class="btn-hero-primary">Pesan Sekarang</a>
            @guest
                <a href="/register" class="btn-hero-secondary">Daftar Akun</a>
            @else
                <a href="/profil" class="btn-hero-secondary">Profil Saya</a>
            @endguest
        </div>
    </div>
</div>

{{-- Features --}}
<div class="features-grid">
    <div class="feature-card">
        <div class="feature-icon">🌶️</div>
        <div class="feature-title">Rempah Pilihan Asli</div>
        <div class="feature-desc">Menggunakan bahan dan rempah berkualitas tinggi yang diimpor langsung dari petani lokal.</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">⭐</div>
        <div class="feature-title">Loyalty Points</div>
        <div class="feature-desc">Dapatkan 10 poin untuk setiap transaksi dan kumpulkan untuk menaikkan level keanggotaan Anda.</div>
    </div>
    <div class="feature-card">
        <div class="feature-icon">🚚</div>
        <div class="feature-title">Pengiriman Cepat</div>
        <div class="feature-desc">Pesanan Anda akan diproses dengan cepat dan dikemas secara higienis hingga sampai di tujuan.</div>
    </div>
</div>

@guest
{{-- Promo Banner --}}
<div class="promo-banner">
    <div class="promo-text">
        <h3>🎁 Promo Spesial Pelanggan Baru!</h3>
        <p>Dapatkan diskon eksklusif dan mulai kumpulkan poin loyalitas Anda. Daftar sekarang dan nikmati pengalaman kuliner terbaik bersama Jinemo.</p>
    </div>
    <a href="/register" class="btn-hero-primary" style="white-space: nowrap; z-index: 2;">Klaim Promo</a>
</div>
@endguest

{{-- Recommended Products --}}
<div>
    <h2 class="section-title">Menu Rekomendasi Kami</h2>
    <div class="product-grid">
        @foreach($products->take(8) as $p)
        <div class="prod-card">
            @if($p->gambar)
                <div class="prod-img" style="background-image: url('{{ Storage::url($p->gambar) }}')">
                    <span class="prod-badge">⭐ Rekomendasi</span>
                </div>
            @else
                <div class="prod-img">
                    <div style="height:100%; display:flex; align-items:center; justify-content:center; color:var(--text-muted); font-size:2rem;">🍽️</div>
                </div>
            @endif
            <div class="prod-body">
                <div class="prod-title">{{ $p->nama_produk }}</div>
                <div class="prod-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                <a href="/produk/{{ $p->id }}" class="prod-btn">Lihat Detail Menu</a>
            </div>
        </div>
        @endforeach
    </div>
    <div style="text-align: center; margin-top: 40px;">
        <a href="/produk" class="btn-hero-secondary" style="display:inline-block;">Lihat Semua Menu ➔</a>
    </div>
</div>

<br><br>
@endsection
