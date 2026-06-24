@extends('layouts.app')

@section('content')
<div style="max-width: 600px; margin: 40px auto;">
    <h2 class="mb-2">Beri Testimoni</h2>
    <div class="card">
        @if(session('success'))
            <div style="padding: 15px; background: rgba(0, 255, 0, 0.2); border: 1px solid #0f0; border-radius: var(--radius); margin-bottom: 20px; color: #afa;">
                {{ session('success') }}
            </div>
        @endif
        <form method="POST" action="/testimoni">
            @csrf
            <div class="form-group">
                <label>Rating (1-5)</label>
                <select name="rating" class="form-control" required style="appearance: none;">
                    <option value="5">⭐⭐⭐⭐⭐ - Sangat Memuaskan</option>
                    <option value="4">⭐⭐⭐⭐ - Memuaskan</option>
                    <option value="3">⭐⭐⭐ - Cukup</option>
                    <option value="2">⭐⭐ - Kurang</option>
                    <option value="1">⭐ - Sangat Kurang</option>
                </select>
            </div>
            <div class="form-group">
                <label>Komentar</label>
                <textarea name="komentar" class="form-control" rows="5" required placeholder="Bagikan pengalaman Anda menikmati masakan Jinemo..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width: 100%;">[Simpan]</button>
        </form>
    </div>
</div>
@endsection
