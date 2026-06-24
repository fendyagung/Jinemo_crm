@extends('layouts.admin')

@section('content')
<h1 class="mb-2">Dashboard</h1>
<div class="grid">
    <div class="card text-center" style="border-top: 4px solid var(--primary);">
        <h3 style="color: var(--text-muted);">Total Pelanggan</h3>
        <p style="font-size: 2.5rem; font-weight: bold; margin-top: 10px;">{{ $total_pelanggan }}</p>
    </div>
    <div class="card text-center" style="border-top: 4px solid var(--primary);">
        <h3 style="color: var(--text-muted);">Total Produk</h3>
        <p style="font-size: 2.5rem; font-weight: bold; margin-top: 10px;">{{ $total_produk }}</p>
    </div>
    <div class="card text-center" style="border-top: 4px solid var(--primary);">
        <h3 style="color: var(--text-muted);">Total Pesanan</h3>
        <p style="font-size: 2.5rem; font-weight: bold; margin-top: 10px;">{{ $total_pesanan }}</p>
    </div>
    <div class="card text-center" style="border-top: 4px solid var(--primary);">
        <h3 style="color: var(--text-muted);">Total Pengaduan</h3>
        <p style="font-size: 2.5rem; font-weight: bold; margin-top: 10px;">{{ $total_pengaduan }}</p>
    </div>
</div>
@endsection
