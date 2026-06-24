@extends('layouts.admin')

@section('content')
<style>
.page-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px; }
.page-title  { font-size:1.4rem; font-weight:800; }
.page-sub    { color:var(--text-muted); font-size:0.88rem; margin-top:4px; }
.summary-strip { display:flex; gap:16px; margin-bottom:24px; }
.strip-card  { background:var(--card-bg); border-radius:12px; padding:16px 20px; border:1px solid rgba(255,255,255,0.06); flex:1; text-align:center; }
.strip-num   { font-size:1.8rem; font-weight:800; }
.strip-label { font-size:0.8rem; color:var(--text-muted); margin-top:2px; }
.panel-card  { background:var(--card-bg); border-radius:16px; border:1px solid rgba(255,255,255,0.06); overflow:hidden; }
.panel-header{ padding:18px 24px; border-bottom:1px solid rgba(255,255,255,0.05); display:flex; justify-content:space-between; align-items:center; }
.data-table  { width:100%; border-collapse:collapse; }
.data-table th{ padding:12px 20px; text-align:left; color:var(--text-muted); font-size:0.78rem; font-weight:600; text-transform:uppercase; letter-spacing:0.5px; background:rgba(255,255,255,0.02); }
.data-table td{ padding:16px 20px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:0.9rem; vertical-align:middle; }
.data-table tr:last-child td { border-bottom:none; }
.data-table tr:hover td      { background:rgba(255,255,255,0.02); }
.avatar { width:36px; height:36px; border-radius:50%; background:linear-gradient(135deg,#f0a500,#cf8d00); display:flex; align-items:center; justify-content:center; font-weight:700; color:#1a1a1a; font-size:0.85rem; flex-shrink:0; }
.user-cell { display:flex; align-items:center; gap:10px; }
.status-badge { display:inline-flex; align-items:center; gap:5px; padding:4px 10px; border-radius:50px; font-size:0.8rem; font-weight:600; }
.status-baru     { background:rgba(239,68,68,0.15); color:#ef4444; }
.status-proses   { background:rgba(59,130,246,0.15); color:#3b82f6; }
.status-selesai  { background:rgba(34,197,94,0.15); color:#22c55e; }
.keluhan-preview { color:rgba(255,255,255,0.7); font-size:0.88rem; max-width:260px; }
.btn-sm { padding:6px 12px; border-radius:8px; border:none; cursor:pointer; font-size:0.82rem; font-weight:600; transition:0.2s; }
.btn-sm-primary { background:rgba(59,130,246,0.15); color:#3b82f6; }
.btn-sm-primary:hover { background:rgba(59,130,246,0.3); }
.btn-sm-success { background:rgba(34,197,94,0.15); color:#22c55e; }
.btn-sm-success:hover { background:rgba(34,197,94,0.3); }
.empty-state { text-align:center; padding:50px; color:var(--text-muted); }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">📢 Kelola Pengaduan</h1>
        <p class="page-sub">Pantau dan tangani keluhan dari pelanggan</p>
    </div>
</div>

{{-- Summary Strip --}}
@php
    $total   = $complaints->count();
    $baru    = $complaints->where('status', 'Baru')->count();
    $proses  = $complaints->where('status', 'Diproses')->count();
    $selesai = $complaints->where('status', 'Selesai')->count();
@endphp
<div class="summary-strip">
    <div class="strip-card">
        <div class="strip-num">{{ $total }}</div>
        <div class="strip-label">Total Pengaduan</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#ef4444;">{{ $baru }}</div>
        <div class="strip-label">🔴 Baru / Belum Ditangani</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#3b82f6;">{{ $proses }}</div>
        <div class="strip-label">🔵 Sedang Diproses</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#22c55e;">{{ $selesai }}</div>
        <div class="strip-label">🟢 Selesai</div>
    </div>
</div>

<div class="panel-card">
    <div class="panel-header">
        <span style="font-weight:700;">Daftar Pengaduan Masuk</span>
        @if($baru > 0)
            <span style="background:rgba(239,68,68,0.15); color:#ef4444; font-size:0.8rem; font-weight:600; padding:4px 12px; border-radius:50px;">{{ $baru }} belum ditangani</span>
        @else
            <span style="background:rgba(34,197,94,0.1); color:#22c55e; font-size:0.8rem; font-weight:600; padding:4px 12px; border-radius:50px;">✓ Semua tertangani</span>
        @endif
    </div>

    @if($complaints->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Subjek</th>
                <th>Isi Keluhan</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($complaints as $c)
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ strtoupper(substr($c->user->name ?? 'A', 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:600; font-size:0.9rem;">{{ $c->user->name ?? 'Pelanggan' }}</div>
                            <div style="color:var(--text-muted); font-size:0.78rem;">{{ $c->user->email ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td style="font-weight:600; font-size:0.9rem;">{{ $c->subjek }}</td>
                <td><div class="keluhan-preview">{{ Str::limit($c->isi_keluhan, 70) }}</div></td>
                <td>
                    @php
                        $stClass = match($c->status) {
                            'Selesai'  => 'status-selesai',
                            'Diproses' => 'status-proses',
                            default    => 'status-baru',
                        };
                        $stIcon = match($c->status) {
                            'Selesai'  => '✓',
                            'Diproses' => '⟳',
                            default    => '!',
                        };
                    @endphp
                    <span class="status-badge {{ $stClass }}">{{ $stIcon }} {{ $c->status }}</span>
                </td>
                <td style="color:var(--text-muted); font-size:0.82rem; white-space:nowrap;">
                    {{ $c->created_at->format('d M Y') }}<br>
                    <span style="font-size:0.78rem;">{{ $c->created_at->diffForHumans() }}</span>
                </td>
                <td>
                    <div style="display:flex; gap:6px;">
                        @if($c->status === 'Baru')
                            <button class="btn-sm btn-sm-primary">⟳ Proses</button>
                        @endif
                        @if($c->status !== 'Selesai')
                            <button class="btn-sm btn-sm-success">✓ Selesai</button>
                        @else
                            <span style="color:var(--text-muted); font-size:0.82rem;">Tertangani</span>
                        @endif
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="empty-state">
            <div style="font-size:48px; margin-bottom:12px;">📢</div>
            <p style="font-weight:600;">Tidak Ada Pengaduan</p>
            <p style="font-size:0.85rem; margin-top:4px;">Semua pelanggan puas dengan layanan Jinemo.</p>
        </div>
    @endif
</div>
@endsection
