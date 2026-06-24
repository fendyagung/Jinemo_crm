@extends('layouts.admin')

@section('content')
<style>
.page-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px; }
.page-title  { font-size:1.4rem; font-weight:800; }
.page-sub    { color:var(--text-muted); font-size:0.88rem; margin-top:4px; }

/* Stat Cards */
.stat-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:18px; margin-bottom:28px; }
.stat-card { background:var(--card-bg); border-radius:16px; padding:22px; border:1px solid rgba(255,255,255,0.06); position:relative; overflow:hidden; }
.stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; }
.stat-card.gold::before   { background:linear-gradient(90deg,#f0a500,#cf8d00); }
.stat-card.green::before  { background:linear-gradient(90deg,#22c55e,#16a34a); }
.stat-card.blue::before   { background:linear-gradient(90deg,#3b82f6,#1d4ed8); }
.stat-card.purple::before { background:linear-gradient(90deg,#a855f7,#7c3aed); }
.stat-icon { width:44px; height:44px; border-radius:11px; display:flex; align-items:center; justify-content:center; font-size:20px; margin-bottom:14px; }
.stat-icon.gold   { background:rgba(240,165,0,0.12); }
.stat-icon.green  { background:rgba(34,197,94,0.12); }
.stat-icon.blue   { background:rgba(59,130,246,0.12); }
.stat-icon.purple { background:rgba(168,85,247,0.12); }
.stat-num   { font-size:1.9rem; font-weight:800; line-height:1; margin-bottom:5px; }
.stat-label { color:var(--text-muted); font-size:0.82rem; }

/* Section layout */
.section-grid { display:grid; grid-template-columns:1fr 1fr; gap:22px; margin-bottom:22px; }
.panel-card { background:var(--card-bg); border-radius:16px; border:1px solid rgba(255,255,255,0.06); overflow:hidden; }
.panel-hdr  { padding:16px 22px; border-bottom:1px solid rgba(255,255,255,0.05); font-weight:700; font-size:0.95rem; display:flex; justify-content:space-between; align-items:center; }

/* Stat rows */
.stat-row { display:flex; justify-content:space-between; align-items:center; padding:14px 22px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:0.9rem; }
.stat-row:last-child { border-bottom:none; }
.stat-row span:first-child { color:var(--text-muted); display:flex; align-items:center; gap:8px; }
.stat-row span:last-child  { font-weight:700; }

/* Status donut-style */
.status-item { display:flex; align-items:center; justify-content:space-between; padding:12px 22px; border-bottom:1px solid rgba(255,255,255,0.04); }
.status-item:last-child { border-bottom:none; }
.status-bar-wrap { flex:1; margin:0 16px; background:rgba(255,255,255,0.07); border-radius:50px; height:8px; overflow:hidden; }
.status-bar { height:100%; border-radius:50px; }

/* Bulan table */
.bulan-table { width:100%; border-collapse:collapse; }
.bulan-table th { padding:10px 22px; text-align:left; color:var(--text-muted); font-size:0.78rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; background:rgba(255,255,255,0.02); }
.bulan-table td { padding:13px 22px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:0.88rem; vertical-align:middle; }
.bulan-table tr:last-child td { border-bottom:none; }
.bulan-table tr:hover td { background:rgba(255,255,255,0.02); }

@media (max-width:1024px) {
    .stat-grid { grid-template-columns:repeat(2,1fr); }
    .section-grid { grid-template-columns:1fr; }
}

/* Print CSS for Saving to PDF */
@media print {
    body { background: #fff !important; color: #000 !important; }
    .sidebar, .admin-topbar, .btn-print { display: none !important; }
    .admin-layout { display: block !important; }
    .admin-content { padding: 0 !important; margin: 0 !important; }
    .page-header { margin-top: 0 !important; padding-top: 0 !important; }
    .stat-card, .panel-card { border: 1px solid #ccc !important; box-shadow: none !important; background: #fff !important; break-inside: avoid; color: #000 !important; }
    .stat-card::before { display: none !important; }
    .stat-num, .stat-label, .panel-hdr, .stat-row span, .bulan-table th, .bulan-table td { color: #000 !important; }
    .status-bar-wrap { background: #eee !important; }
    .bulan-table td span { color: #000 !important; background: transparent !important; border: 1px solid #ccc; }
    * { -webkit-print-color-adjust: exact !important; color-adjust: exact !important; }
}
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">📊 Laporan Bisnis</h1>
        <p class="page-sub">Ringkasan performa dan data bisnis Jinemo — {{ date('Y') }}</p>
    </div>
    <div style="display:flex; gap:16px; align-items:center;">
        <button onclick="window.print()" class="btn-print" style="background:var(--primary); color:#1a1a1a; padding:10px 20px; border:none; border-radius:10px; font-weight:700; cursor:pointer; display:flex; align-items:center; gap:8px; transition:0.2s;" onmouseover="this.style.transform='translateY(-2px)'" onmouseout="this.style.transform='none'">
            🖨️ Cetak / Simpan PDF
        </button>
        <div style="color:var(--text-muted); font-size:0.85rem; text-align:right;" class="d-print-none">
            <div style="font-weight:600; color:var(--text-light);">{{ now()->format('d F Y') }}</div>
            <div>{{ now()->format('H:i') }} WIT</div>
        </div>
    </div>
</div>

{{-- KPI Cards --}}
<div class="stat-grid">
    <div class="stat-card gold">
        <div class="stat-icon gold">💰</div>
        <div class="stat-num">Rp {{ number_format($total_pendapatan, 0, ',', '.') }}</div>
        <div class="stat-label">Total Pendapatan (Selesai)</div>
    </div>
    <div class="stat-card green">
        <div class="stat-icon green">📦</div>
        <div class="stat-num">{{ $total_pesanan }}</div>
        <div class="stat-label">Total Pesanan Masuk</div>
    </div>
    <div class="stat-card blue">
        <div class="stat-icon blue">👥</div>
        <div class="stat-num">{{ $total_pelanggan }}</div>
        <div class="stat-label">Total Pelanggan</div>
    </div>
    <div class="stat-card purple">
        <div class="stat-icon purple">⭐</div>
        <div class="stat-num">{{ number_format($rata_rating, 1) }}/5</div>
        <div class="stat-label">Rata-rata Rating Pelanggan</div>
    </div>
</div>

<div class="section-grid">
    {{-- Status Pesanan --}}
    <div class="panel-card">
        <div class="panel-hdr">
            📦 Status Pesanan
            <span style="font-size:0.8rem; color:var(--text-muted); font-weight:400;">Total: {{ $total_pesanan }}</span>
        </div>
        @php
            $items = [
                ['Selesai',  $pesanan_selesai,  '#22c55e'],
                ['Diproses', $pesanan_diproses, '#3b82f6'],
                ['Pending',  $pesanan_pending,  '#eab308'],
                ['Batal',    ($total_pesanan - $pesanan_selesai - $pesanan_diproses - $pesanan_pending), '#ef4444'],
            ];
        @endphp
        @foreach($items as [$label, $count, $color])
        <div class="status-item">
            <div style="display:flex; align-items:center; gap:8px; min-width:90px;">
                <span style="width:10px; height:10px; border-radius:50%; background:{{ $color }}; display:inline-block;"></span>
                <span style="font-size:0.88rem;">{{ $label }}</span>
            </div>
            <div class="status-bar-wrap">
                <div class="status-bar" style="width:{{ $total_pesanan > 0 ? round(($count/$total_pesanan)*100) : 0 }}%; background:{{ $color }};"></div>
            </div>
            <div style="font-weight:700; font-size:0.88rem; min-width:30px; text-align:right;">{{ $count }}</div>
        </div>
        @endforeach
    </div>

    {{-- Ringkasan Bisnis --}}
    <div class="panel-card">
        <div class="panel-hdr">📈 Ringkasan Bisnis</div>
        <div class="stat-row">
            <span>🍽️ Total Menu Aktif</span>
            <span>{{ $total_produk }} menu</span>
        </div>
        <div class="stat-row">
            <span>📦 Pesanan Berhasil</span>
            <span style="color:#22c55e;">{{ $pesanan_selesai }} pesanan</span>
        </div>
        <div class="stat-row">
            <span>📢 Total Pengaduan</span>
            <span style="color:#ef4444;">{{ $total_pengaduan }} pengaduan</span>
        </div>
        <div class="stat-row">
            <span>⭐ Total Ulasan</span>
            <span>{{ $total_testimoni }} ulasan</span>
        </div>
        <div class="stat-row">
            <span>💰 Rata-rata Nilai Pesanan</span>
            <span style="color:var(--primary);">
                Rp {{ $total_pesanan > 0 ? number_format($total_pendapatan / max($pesanan_selesai,1), 0, ',', '.') : '0' }}
            </span>
        </div>
        <div class="stat-row">
            <span>📊 Tingkat Konversi</span>
            <span style="color:#22c55e;">
                {{ $total_pesanan > 0 ? round(($pesanan_selesai/$total_pesanan)*100) : 0 }}%
            </span>
        </div>
    </div>
</div>

{{-- Tabel Pesanan Per Bulan --}}
<div class="panel-card">
    <div class="panel-hdr">
        📅 Laporan Pesanan Per Bulan — {{ date('Y') }}
        <span style="font-size:0.8rem; color:var(--text-muted); font-weight:400;">{{ $pesanan_bulanan->count() }} bulan aktif</span>
    </div>
    @if($pesanan_bulanan->count() > 0)
    <table class="bulan-table">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Jumlah Pesanan</th>
                <th>Total Pendapatan</th>
                <th>Grafik</th>
            </tr>
        </thead>
        <tbody>
        @php
            $namaBulan = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
            $maxTotal  = $pesanan_bulanan->max('total') ?: 1;
        @endphp
        @foreach($pesanan_bulanan as $row)
        <tr>
            <td style="font-weight:600;">{{ $namaBulan[$row->bulan] ?? 'Bln '.$row->bulan }}</td>
            <td>
                <span style="background:rgba(59,130,246,0.12); color:#3b82f6; padding:3px 10px; border-radius:50px; font-size:0.82rem; font-weight:600;">
                    {{ $row->total }} pesanan
                </span>
            </td>
            <td style="font-weight:700; color:var(--primary);">Rp {{ number_format($row->pendapatan, 0, ',', '.') }}</td>
            <td>
                <div style="background:rgba(255,255,255,0.07); border-radius:50px; height:8px; width:180px; overflow:hidden;">
                    <div style="height:100%; border-radius:50px; background:linear-gradient(90deg,#f0a500,#cf8d00); width:{{ round(($row->total/$maxTotal)*100) }}%;"></div>
                </div>
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
    @else
        <div style="text-align:center; padding:40px; color:var(--text-muted);">
            <div style="font-size:40px; margin-bottom:10px;">📊</div>
            <p>Belum ada data pesanan untuk tahun ini.</p>
        </div>
    @endif
</div>
@endsection
