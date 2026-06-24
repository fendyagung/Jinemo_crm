@extends('layouts.app')

@section('content')
<h2 class="mb-2">Katalog Menu Masakan Nusantara</h2>
<div class="grid">
    @foreach($products as $p)
    <div class="card text-center">
        @if($p->gambar)
            <div style="height: 200px; background: url('{{ Storage::url($p->gambar) }}') center/cover no-repeat; border-radius: var(--radius) var(--radius) 0 0; margin: -20px -20px 20px -20px;"></div>
        @else
            <div style="height: 200px; background: rgba(255,255,255,0.05); border-radius: var(--radius) var(--radius) 0 0; margin: -20px -20px 20px -20px; display:flex; align-items:center; justify-content:center; color: var(--text-muted);">Foto</div>
        @endif
        <h3>{{ $p->nama_produk }}</h3>
        <p style="color: var(--primary); font-weight: bold; font-size: 1.2rem; margin: 10px 0;">Rp {{ number_format($p->harga, 0, ',', '.') }}</p>
        <a href="/produk/{{ $p->id }}" class="btn btn-primary" style="width: 100%;">Lihat Detail</a>
    </div>
    @endforeach
</div>
@endsection
