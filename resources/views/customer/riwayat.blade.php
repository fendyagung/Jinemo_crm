@extends('layouts.app')

@section('content')
<h2 class="mb-2">Riwayat Pesanan</h2>
<div class="card">
    @if($orders->count() > 0)
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Total Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>
                    <span style="padding: 5px 10px; border-radius: 20px; font-size: 0.9rem; background: rgba(255,255,255,0.1);">
                        {{ $order->status }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p style="text-align: center; color: var(--text-muted); padding: 20px 0;">Belum ada riwayat pesanan.</p>
    @endif
</div>
@endsection
