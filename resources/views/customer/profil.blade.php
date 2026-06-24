@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 40px auto;">
    <h2 class="mb-2">Profil Pelanggan</h2>
    <div class="card">
        <div class="form-group">
            <label>Nama Lengkap</label>
            <div class="form-control" style="background: rgba(255,255,255,0.1);">{{ auth()->user()->name }}</div>
        </div>
        <div class="form-group">
            <label>Email</label>
            <div class="form-control" style="background: rgba(255,255,255,0.1);">{{ auth()->user()->email }}</div>
        </div>
        <div class="form-group">
            <label>Loyalty Point (Acquiring & Retaining Customers)</label>
            <div class="form-control" style="background: rgba(240, 165, 0, 0.2); color: var(--primary); font-weight: bold; font-size: 1.5rem;">
                {{ auth()->user()->point }} Pts
            </div>
        </div>
        <h3 class="mt-2 mb-2">Menu Favorit Anda</h3>
        @if($favorites->count() > 0)
            <ul style="list-style: none;">
            @foreach($favorites as $fav)
                <li style="padding: 10px; border-bottom: 1px solid rgba(255,255,255,0.1); display:flex; justify-content: space-between;">
                    <span>{{ $fav->nama_produk }}</span>
                    <a href="/produk/{{ $fav->product_id }}" class="btn btn-primary" style="padding: 5px 10px; font-size: 0.9rem;">Pesan Lagi</a>
                </li>
            @endforeach
            </ul>
        @else
            <p style="color: var(--text-muted);">Belum ada menu favorit.</p>
        @endif
    </div>
</div>
@endsection
