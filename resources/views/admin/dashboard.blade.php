@extends('layouts.admin')

@section('content')
<style>
.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 32px;
}
.stat-card {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 24px;
    border: 1px solid rgba(255,255,255,0.06);
    position: relative;
    overflow: hidden;
    transition: 0.3s;
}
.stat-card:hover {
    transform: translateY(-3px);
    border-color: rgba(255,255,255,0.12);
}
.stat-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
}
.stat-card.gold::before   { background: linear-gradient(90deg, #f0a500, #cf8d00); }
.stat-card.blue::before   { background: linear-gradient(90deg, #3b82f6, #1d4ed8); }
.stat-card.green::before  { background: linear-gradient(90deg, #22c55e, #16a34a); }
.stat-card.red::before    { background: linear-gradient(90deg, #ef4444, #dc2626); }
.stat-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px;
    margin-bottom: 16px;
}
.stat-icon.gold  { background: rgba(240,165,0,0.12); }
.stat-icon.blue  { background: rgba(59,130,246,0.12); }
.stat-icon.green { background: rgba(34,197,94,0.12); }
.stat-icon.red   { background: rgba(239,68,68,0.12); }
.stat-number {
    font-size: 2.2rem;
    font-weight: 800;
    line-height: 1;
    margin-bottom: 6px;
}
.stat-label { color: var(--text-muted); font-size: 0.85rem; font-weight: 500; }
.stat-trend { font-size: 0.8rem; margin-top: 10px; }
.stat-trend.up   { color: #22c55e; }
.stat-trend.down { color: #ef4444; }

/* Shortcut grid */
.shortcut-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 16px;
    margin-bottom: 32px;
}
.shortcut-card {
    background: var(--card-bg);
    border-radius: 14px;
    border: 1px solid rgba(255,255,255,0.06);
    padding: 20px;
    text-align: center;
    text-decoration: none;
    color: var(--text-light);
    transition: 0.25s;
    display: block;
}
.shortcut-card:hover {
    border-color: rgba(240,165,0,0.3);
    background: rgba(240,165,0,0.05);
    color: var(--primary);
    transform: translateY(-2px);
}
.shortcut-icon { font-size: 30px; margin-bottom: 10px; }
.shortcut-label { font-weight: 600; font-size: 0.9rem; }

/* Recent Orders Table */
.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 16px;
}
.section-title { font-size: 1.05rem; font-weight: 700; }
.section-link { color: var(--primary); font-size: 0.85rem; text-decoration: none; }
.section-link:hover { text-decoration: underline; }
.data-table { width: 100%; border-collapse: collapse; }
.data-table th {
    padding: 12px 16px;
    text-align: left;
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: rgba(255,255,255,0.02);
}
.data-table td {
    padding: 14px 16px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-size: 0.9rem;
    vertical-align: middle;
}
.data-table tr:last-child td { border-bottom: none; }
.data-table tr:hover td { background: rgba(255,255,255,0.02); }
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 4px 10px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
}
.status-pending  { background: rgba(234,179,8,0.15); color: #eab308; }
.status-selesai  { background: rgba(34,197,94,0.15); color: #22c55e; }
.status-batal    { background: rgba(239,68,68,0.15); color: #ef4444; }
.dashboard-bottom {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
}
.panel-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.06);
    overflow: hidden;
}
.panel-card-header {
    padding: 16px 20px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    font-weight: 700;
    font-size: 0.95rem;
}
@media (max-width: 1024px) {
    .stats-grid { grid-template-columns: repeat(2, 1fr); }
    .dashboard-bottom { grid-template-columns: 1fr; }
}
</style>

{{-- Header --}}
<div style="display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px;">
    <div>
        <h1 style="font-size:1.6rem; font-weight:800; margin-bottom:4px;">Dashboard Admin</h1>
        <p style="color:var(--text-muted); font-size:0.9rem;">Selamat datang, <strong style="color:var(--primary);">{{ auth()->user()->name }}</strong> — {{ now()->format('l, d F Y') }}</p>
    </div>
</div>

{{-- Stats Cards --}}
<div class="stats-grid">
    <div class="stat-card gold">
        <div class="stat-icon gold">👥</div>
        <div class="stat-number">{{ $total_pelanggan }}</div>
        <div class="stat-label">Total Pelanggan</div>
        <div class="stat-trend up">↑ Terdaftar</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon blue">🍽️</div>
        <div class="stat-number">{{ $total_produk }}</div>
        <div class="stat-label">Total Menu</div>
        <div class="stat-trend up">↑ Aktif tersedia</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green">📦</div>
        <div class="stat-number">{{ $total_pesanan }}</div>
        <div class="stat-label">Total Pesanan</div>
        <div class="stat-trend up">↑ Masuk</div>
    </div>
    <div class="stat-card red">
        <div class="stat-icon red">📢</div>
        <div class="stat-number">{{ $total_pengaduan }}</div>
        <div class="stat-label">Pengaduan</div>
        <div class="stat-trend">Perlu ditangani</div>
    </div>
</div>

{{-- Shortcut Menu --}}
<div style="margin-bottom: 16px;">
    <div style="font-size: 0.82rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 14px;">Menu Cepat</div>
    <div class="shortcut-grid">
        <a href="/admin/produk" class="shortcut-card">
            <div class="shortcut-icon">🍽️</div>
            <div class="shortcut-label">Kelola Menu</div>
        </a>
        <a href="/admin/pelanggan" class="shortcut-card">
            <div class="shortcut-icon">👥</div>
            <div class="shortcut-label">Data Pelanggan</div>
        </a>
        <a href="/admin/pesanan" class="shortcut-card">
            <div class="shortcut-icon">📦</div>
            <div class="shortcut-label">Kelola Pesanan</div>
        </a>
        <a href="/admin/testimoni" class="shortcut-card">
            <div class="shortcut-icon">⭐</div>
            <div class="shortcut-label">Ulasan</div>
        </a>
        <a href="/admin/pengaduan" class="shortcut-card">
            <div class="shortcut-icon">📢</div>
            <div class="shortcut-label">Pengaduan</div>
        </a>
    </div>
</div>

{{-- Bottom: Pesanan Terbaru + Pelanggan Terbaru --}}
<div class="dashboard-bottom">
    {{-- Pesanan Terbaru --}}
    <div class="panel-card">
        <div class="panel-card-header" style="display:flex; justify-content:space-between;">
            <span>📦 Pesanan Terbaru</span>
            <a href="/admin/pesanan" class="section-link">Lihat semua →</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pelanggan</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_orders as $order)
                <tr>
                    <td style="font-family:monospace; color:var(--primary); font-weight:700;">#{{ str_pad($order->id, 4, '0', STR_PAD_LEFT) }}</td>
                    <td>{{ $order->user->name ?? '-' }}</td>
                    <td style="font-weight:600;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td>
                        @php
                            $cls = match(strtolower($order->status)) {
                                'selesai' => 'status-selesai', 'batal' => 'status-batal', default => 'status-pending'
                            };
                        @endphp
                        <span class="status-badge {{ $cls }}">{{ $order->status }}</span>
                    </td>
                </tr>
                @endforeach
                @if($recent_orders->count() === 0)
                <tr><td colspan="4" style="text-align:center; color:var(--text-muted); padding:24px;">Belum ada pesanan</td></tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Pelanggan Terbaru --}}
    <div class="panel-card">
        <div class="panel-card-header" style="display:flex; justify-content:space-between;">
            <span>👥 Pelanggan Terbaru</span>
            <a href="/admin/pelanggan" class="section-link">Lihat semua →</a>
        </div>
        <table class="data-table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Poin</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recent_customers as $c)
                <tr>
                    <td>
                        <div style="display:flex; align-items:center; gap:10px;">
                            <div style="width:32px; height:32px; border-radius:50%; background:var(--primary); display:flex; align-items:center; justify-content:center; font-weight:700; color:#1a1a1a; font-size:0.85rem; flex-shrink:0;">
                                {{ strtoupper(substr($c->name, 0, 1)) }}
                            </div>
                            <span style="font-weight:600;">{{ $c->name }}</span>
                        </div>
                    </td>
                    <td style="color:var(--text-muted); font-size:0.85rem;">{{ $c->email }}</td>
                    <td style="color:var(--primary); font-weight:700;">{{ $c->point }} pts</td>
                </tr>
                @endforeach
                @if($recent_customers->count() === 0)
                <tr><td colspan="3" style="text-align:center; color:var(--text-muted); padding:24px;">Belum ada pelanggan</td></tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
