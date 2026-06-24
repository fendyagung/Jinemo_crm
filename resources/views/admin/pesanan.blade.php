@extends('layouts.admin')

@section('content')
<h1 class="mb-2">Kelola Pesanan</h1>
<div class="card">
    <table>
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->user->name ?? 'User' }}</td>
                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    <button class="btn btn-primary" style="padding: 5px 10px; font-size: 0.8rem;">Proses</button>
                    <button class="btn" style="padding: 5px 10px; font-size: 0.8rem; background:rgba(255,255,255,0.1); color:white;">Selesai</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
