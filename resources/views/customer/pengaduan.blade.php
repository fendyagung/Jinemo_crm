@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 40px auto;">
    <h2 class="mb-2">Pengaduan Online</h2>
    <div class="card">
        @if(session('success'))
            <div style="padding: 15px; background: rgba(0, 255, 0, 0.2); border: 1px solid #0f0; border-radius: var(--radius); margin-bottom: 20px; color: #afa;">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="/pengaduan">
            @csrf
            <div class="form-group">
                <label>Subjek</label>
                <input type="text" name="subjek" class="form-control" required placeholder="Misal: Pesanan Terlambat, Kemasan Rusak">
            </div>
            <div class="form-group">
                <label>Isi Keluhan</label>
                <textarea name="isi_keluhan" class="form-control" rows="5" required placeholder="Jelaskan detail keluhan Anda..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">[Kirim]</button>
        </form>
    </div>
</div>
@endsection
