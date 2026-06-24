@extends('layouts.admin')

@section('content')
<h1 class="mb-2">Kelola Testimoni</h1>
<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $index => $testimoni)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $testimoni->user->name ?? 'User' }}</td>
                <td style="color: var(--primary);">{{ str_repeat('⭐', $testimoni->rating) }}</td>
                <td>{{ $testimoni->komentar }}</td>
                <td>
                    <button class="btn btn-danger" style="padding: 5px 10px; font-size: 0.8rem;">Hapus</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
