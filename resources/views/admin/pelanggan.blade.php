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
.data-table td{ padding:14px 20px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:0.9rem; vertical-align:middle; }
.data-table tr:last-child td { border-bottom:none; }
.data-table tr:hover td { background:rgba(255,255,255,0.02); }
.user-cell { display:flex; align-items:center; gap:12px; }
.avatar-wrap {
    width:42px; height:42px; border-radius:50%; overflow:hidden; flex-shrink:0;
    background:linear-gradient(135deg,#f0a500,#cf8d00);
    display:flex; align-items:center; justify-content:center;
    font-weight:700; color:#1a1a1a; font-size:1rem;
}
.avatar-wrap img { width:100%; height:100%; object-fit:cover; }
.poin-bar-wrap { background:rgba(255,255,255,0.08); border-radius:50px; height:5px; width:80px; overflow:hidden; display:inline-block; vertical-align:middle; margin-left:8px; }
.poin-bar      { height:100%; background:var(--primary); border-radius:50px; }
.rank-badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:50px; font-size:0.78rem; font-weight:600; }
.rank-gold   { background:rgba(240,165,0,0.15); color:#f0a500; }
.rank-silver { background:rgba(156,163,175,0.15); color:#9ca3af; }
.rank-bronze { background:rgba(180,120,60,0.15); color:#b4783c; }
.rank-basic  { background:rgba(255,255,255,0.06); color:var(--text-muted); }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">👥 Kelola Pelanggan</h1>
        <p class="page-sub">Data semua pelanggan terdaftar di Jinemo</p>
    </div>
</div>

{{-- Summary --}}
@php
    $total       = $customers->count();
    $aktif       = $customers->where('point', '>', 0)->count();
    $total_poin  = $customers->sum('point');
    $avg_poin    = $total > 0 ? round($customers->avg('point')) : 0;
@endphp
<div class="summary-strip">
    <div class="strip-card">
        <div class="strip-num">{{ $total }}</div>
        <div class="strip-label">Total Pelanggan</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#22c55e;">{{ $aktif }}</div>
        <div class="strip-label">Pernah Memesan</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:var(--primary);">{{ $total_poin }}</div>
        <div class="strip-label">Total Poin Tersebar</div>
    </div>
    <div class="strip-card">
        <div class="strip-num">{{ $avg_poin }}</div>
        <div class="strip-label">Rata-rata Poin</div>
    </div>
</div>

<div class="panel-card">
    <div class="panel-header">
        <span style="font-weight:700;">Daftar Pelanggan Terdaftar</span>
        <span style="background:rgba(240,165,0,0.1); color:var(--primary); font-size:0.8rem; font-weight:600; padding:4px 12px; border-radius:50px;">{{ $total }} pelanggan</span>
    </div>

    @if($customers->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Email</th>
                <th>Loyalty Points</th>
                <th>Level</th>
                <th>Bergabung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
            @php
                $poin = $customer->point;
                if ($poin >= 100)     { $rank = 'Gold';   $rankClass = 'rank-gold';   $rankIcon = '🥇'; }
                elseif ($poin >= 50)  { $rank = 'Silver'; $rankClass = 'rank-silver'; $rankIcon = '🥈'; }
                elseif ($poin >= 10)  { $rank = 'Bronze'; $rankClass = 'rank-bronze'; $rankIcon = '🥉'; }
                else                  { $rank = 'Basic';  $rankClass = 'rank-basic';  $rankIcon = '👤'; }
                $poinPersen = min(100, $poin % 100);
            @endphp
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="avatar-wrap">
                            @if($customer->foto)
                                <img src="{{ Storage::url($customer->foto) }}" alt="">
                            @else
                                {{ strtoupper(substr($customer->name, 0, 1)) }}
                            @endif
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:0.92rem;">{{ $customer->name }}</div>
                            <div style="color:var(--text-muted); font-size:0.78rem;">ID #{{ $customer->id }}</div>
                        </div>
                    </div>
                </td>
                <td style="color:var(--text-muted); font-size:0.85rem;">{{ $customer->email }}</td>
                <td>
                    <div style="display:flex; align-items:center; gap:8px;">
                        <span style="font-weight:700; color:var(--primary);">{{ $poin }}</span>
                        <div class="poin-bar-wrap">
                            <div class="poin-bar" style="width:{{ $poinPersen }}%;"></div>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="rank-badge {{ $rankClass }}">{{ $rankIcon }} {{ $rank }}</span>
                </td>
                <td style="color:var(--text-muted); font-size:0.82rem; white-space:nowrap;">
                    {{ $customer->created_at->format('d M Y') }}<br>
                    <span style="font-size:0.78rem;">{{ $customer->created_at->diffForHumans() }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div style="text-align:center; padding:50px; color:var(--text-muted);">
            <div style="font-size:48px; margin-bottom:12px;">👥</div>
            <p style="font-weight:600;">Belum Ada Pelanggan</p>
        </div>
    @endif
</div>
@endsection
