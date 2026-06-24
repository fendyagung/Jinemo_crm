@extends('layouts.app')

@section('content')
<div class="text-center" style="padding: 60px 0;">
    <h1 style="font-size: 3rem; color: var(--primary); margin-bottom: 20px;">Cita Rasa Indonesia Timur</h1>
    <p style="font-size: 1.2rem; color: var(--text-muted); max-width: 600px; margin: 0 auto 30px;">
        Nikmati kelezatan masakan khas nusantara dengan sentuhan rempah asli pilihan. Jinemo menyajikan pengalaman kuliner terbaik untuk Anda.
    </p>
    <a href="/produk" class="btn btn-primary" style="font-size: 1.2rem; padding: 15px 40px;">Pesan Sekarang</a>
</div>

<div class="mt-2">
    <h2 class="mb-2">Promo Spesial Pelanggan Baru!</h2>
    <div class="card" style="background: linear-gradient(135deg, rgba(240, 165, 0, 0.2), transparent); border-left: 4px solid var(--primary);">
        <h3>Dapatkan Diskon 20% untuk Pesanan Pertama Anda</h3>
        <p class="mt-2" style="color: var(--text-muted);">Daftar sekarang dan nikmati potongan harga khusus. Gunakan kode promo <strong>JINEMOBARU</strong> saat checkout.</p>
        <a href="/register" class="btn btn-primary mt-2">Daftar Sekarang</a>
    </div>
</div>

<div class="mt-2" style="margin-top: 60px;">
    <h2 class="mb-2">Menu Rekomendasi</h2>
    <div class="grid">
        @foreach($products as $p)
        <div class="card text-center">
            @if($p->gambar)
                <div style="height: 150px; background: url('{{ Storage::url($p->gambar) }}') center/cover no-repeat; border-radius: var(--radius) var(--radius) 0 0; margin: -20px -20px 20px -20px;"></div>
            @else
                <div style="height: 150px; background: rgba(255,255,255,0.05); border-radius: var(--radius) var(--radius) 0 0; margin: -20px -20px 20px -20px;"></div>
            @endif
            <h3>{{ $p->nama_produk }}</h3>
            <p style="color: var(--primary); font-weight: bold; font-size: 1.2rem; margin: 10px 0;">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
            <a href="/produk/{{ $p->id }}" class="btn btn-primary" style="width: 100%;">Lihat Detail</a>
        </div>
        @endforeach
    </div>
</div>
@endsection
