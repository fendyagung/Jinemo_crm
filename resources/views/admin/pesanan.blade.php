@extends('layouts.admin')

@section('content')
<style>
.page-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px; }
.page-title  { font-size:1.4rem; font-weight:800; }
.page-sub    { color:var(--text-muted); font-size:0.88rem; margin-top:4px; }
.summary-strip { display:flex; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.strip-card  { background:var(--card-bg); border-radius:12px; padding:16px 20px; border:1px solid rgba(255,255,255,0.06); flex:1; min-width:140px; text-align:center; }
.strip-num   { font-size:1.8rem; font-weight:800; }
.strip-label { font-size:0.8rem; color:var(--text-muted); margin-top:2px; }
.panel-card  { background:var(--card-bg); border-radius:16px; border:1px solid rgba(255,255,255,0.06); overflow:hidden; }
.panel-header{ padding:18px 24px; border-bottom:1px solid rgba(255,255,255,0.05); display:flex; justify-content:space-between; align-items:center; }
.data-table  { width:100%; border-collapse:collapse; }
.data-table th{ padding:12px 20px; text-align:left; color:var(--text-muted); font-size:0.78rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; background:rgba(255,255,255,0.02); }
.data-table td{ padding:14px 20px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:0.9rem; vertical-align:middle; }
.data-table tr:last-child td { border-bottom:none; }
.data-table tr:hover td { background:rgba(255,255,255,0.02); }
.user-cell { display:flex; align-items:center; gap:10px; }
.avatar { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#f0a500,#cf8d00); display:flex; align-items:center; justify-content:center; font-weight:700; color:#1a1a1a; font-size:0.85rem; flex-shrink:0; }
.order-id { font-family:monospace; font-weight:700; color:var(--primary); }
.status-badge { display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:50px; font-size:0.8rem; font-weight:600; }
.status-pending  { background:rgba(234,179,8,0.15); color:#eab308; }
.status-selesai  { background:rgba(34,197,94,0.15); color:#22c55e; }
.status-diproses { background:rgba(59,130,246,0.15); color:#3b82f6; }
.status-batal    { background:rgba(239,68,68,0.15); color:#ef4444; }
.alert-success { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); color:#22c55e; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:0.9rem; }
.btn-sm-wrap { display:flex; gap:6px; }
select.status-select { padding:5px 10px; border-radius:8px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.05); color:var(--text-light); font-size:0.82rem; cursor:pointer; }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">📦 Kelola Pesanan</h1>
        <p class="page-sub">Monitor dan kelola status semua pesanan pelanggan</p>
    </div>
</div>

@if(session('success'))
    <div class="alert-success">✓ {{ session('success') }}</div>
@endif

{{-- Summary --}}
@php
    $total    = $orders->count();
    $pending  = $orders->where('status', 'Pending')->count();
    $diproses = $orders->where('status', 'Diproses')->count();
    $selesai  = $orders->where('status', 'Selesai')->count();
    $batal    = $orders->where('status', 'Batal')->count();
    $revenue  = $orders->where('status', 'Selesai')->sum('total_harga');
@endphp
<div class="summary-strip">
    <div class="strip-card">
        <div class="strip-num">{{ $total }}</div>
        <div class="strip-label">Total Pesanan</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#eab308;">{{ $pending }}</div>
        <div class="strip-label">⏳ Pending</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#3b82f6;">{{ $diproses }}</div>
        <div class="strip-label">⟳ Diproses</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#22c55e;">{{ $selesai }}</div>
        <div class="strip-label">✓ Selesai</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:var(--primary);">Rp {{ number_format($revenue, 0, ',', '.') }}</div>
        <div class="strip-label">Total Pendapatan</div>
    </div>
</div>

<div class="panel-card">
    <div class="panel-header">
        <span style="font-weight:700;">Daftar Semua Pesanan</span>
        <span style="background:rgba(240,165,0,0.1); color:var(--primary); font-size:0.8rem; font-weight:600; padding:4px 12px; border-radius:50px;">{{ $total }} pesanan</span>
    </div>

    @if($orders->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>ID Pesanan</th>
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Ubah Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td><span class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ strtoupper(substr($order->user->name ?? 'A', 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:600;">{{ $order->user->name ?? 'Pelanggan' }}</div>
                            <div style="color:var(--text-muted); font-size:0.78rem;">{{ $order->user->email ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-weight:700;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>
                    @php
                        $cls = match(strtolower($order->status)) {
                            'selesai'  => 'status-selesai',
                            'diproses' => 'status-diproses',
                            'batal'    => 'status-batal',
                            default    => 'status-pending',
                        };
                    @endphp
                    <span class="status-badge {{ $cls }}">{{ $order->status }}</span>
                </td>
                <td style="color:var(--text-muted); font-size:0.82rem; white-space:nowrap;">
                    {{ $order->created_at->format('d M Y') }}<br>
                    <span style="font-size:0.78rem;">{{ $order->created_at->diffForHumans() }}</span>
                </td>
                <td>
                    <form method="POST" action="{{ route('admin.pesanan.status', $order->id) }}" style="display:flex; gap:6px; align-items:center;">
                        @csrf
                        <select name="status" class="status-select" onchange="this.form.submit()">
                            <option value="Pending"  {{ $order->status == 'Pending'  ? 'selected' : '' }}>⏳ Pending</option>
                            <option value="Diproses" {{ $order->status == 'Diproses' ? 'selected' : '' }}>⟳ Diproses</option>
                            <option value="Selesai"  {{ $order->status == 'Selesai'  ? 'selected' : '' }}>✓ Selesai</option>
                            <option value="Batal"    {{ $order->status == 'Batal'    ? 'selected' : '' }}>✕ Batal</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div style="text-align:center; padding:50px; color:var(--text-muted);">
            <div style="font-size:48px; margin-bottom:12px;">📦</div>
            <p style="font-weight:600;">Belum Ada Pesanan</p>
        </div>
    @endif
</div>
@endsection
