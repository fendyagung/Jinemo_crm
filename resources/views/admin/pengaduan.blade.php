@extends('layouts.admin')

@section('content')
<h1 class="mb-2">Kelola Pengaduan</h1>
<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Pelanggan</th>
                <th>Subjek</th>
                <th>Keluhan</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $index => $complaint)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $complaint->user->name ?? 'User' }}</td>
                <td>{{ $complaint->subjek }}</td>
                <td>{{ Str::limit($complaint->isi_keluhan, 50) }}</td>
                <td>{{ $complaint->status }}</td>
                <td>
                    <button class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;">Tandai Selesai</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
