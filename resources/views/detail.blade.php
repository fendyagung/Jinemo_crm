@extends('layouts.app')

@section('content')
<div class="card" style="max-width: 800px; margin: 0 auto; padding: 40px;">
    <h2 class="mb-2">Detail Produk</h2>
    
    @if($product->gambar)
        <div style="width: 100%; height: 300px; background: url('{{ Storage::url($product->gambar) }}') center/cover no-repeat; border-radius: var(--radius); margin-bottom: 30px;"></div>
    @else
        <div style="width: 100%; height: 300px; background: rgba(255,255,255,0.05); border-radius: var(--radius); display:flex; align-items:center; justify-content:center; color: var(--text-muted); font-size: 24px; margin-bottom: 30px;">
            Foto
        </div>
    @endif

    <h1 style="color: var(--primary); font-size: 2.5rem; margin-bottom: 10px;">{{ $product->nama_produk }}</h1>
    
    <h2 style="font-size: 2rem; margin-bottom: 20px;">Rp {{ number_format($product->harga, 0, ',', '.') }}</h2>
    
    <div style="margin-bottom: 40px; color: var(--text-muted); line-height: 1.8;">
        <h3>Deskripsi</h3>
        <p class="mt-2">{{ $product->deskripsi }}</p>
    </div>

    @auth
        @if(auth()->user()->role === 'customer')
        <form method="POST" action="/pesan/{{ $product->id }}">
            @csrf
            <button type="submit" class="btn btn-primary" style="width: 100%; font-size: 1.2rem; padding: 15px;">Tambah Keranjang (Pesan)</button>
        </form>
        <form method="POST" action="/favorit/{{ $product->id }}" class="mt-2">
            @csrf
            <button type="submit" class="btn" style="width: 100%; font-size: 1.2rem; padding: 15px; background: transparent; border: 1px solid var(--primary); color: var(--primary);">+ Jadikan Menu Favorit</button>
        </form>
        @endif
    @else
        <a href="/login" class="btn btn-primary" style="width: 100%; text-align: center; font-size: 1.2rem; padding: 15px;">Login untuk Memesan</a>
    @endauth
</div>
@endsection
