@extends('layouts.admin')

@section('content')
<style>
.page-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:28px; }
.page-title  { font-size:1.4rem; font-weight:800; }
.page-sub    { color:var(--text-muted); font-size:0.88rem; margin-top:4px; }
.summary-strip {
    display: flex;
    gap: 16px;
    margin-bottom: 24px;
}
.strip-card {
    background: var(--card-bg);
    border-radius: 12px;
    padding: 16px 20px;
    border: 1px solid rgba(255,255,255,0.06);
    flex: 1;
    text-align: center;
}
.strip-num   { font-size: 1.8rem; font-weight: 800; color: var(--primary); }
.strip-label { font-size: 0.8rem; color: var(--text-muted); margin-top: 2px; }
.panel-card  { background: var(--card-bg); border-radius: 16px; border:1px solid rgba(255,255,255,0.06); overflow:hidden; }
.panel-header{
    padding: 18px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.data-table  { width:100%; border-collapse:collapse; }
.data-table th{
    padding:12px 20px;
    text-align:left;
    color:var(--text-muted);
    font-size:0.78rem;
    font-weight:600;
    text-transform:uppercase;
    letter-spacing:0.5px;
    background:rgba(255,255,255,0.02);
}
.data-table td{
    padding:16px 20px;
    border-bottom:1px solid rgba(255,255,255,0.04);
    font-size:0.9rem;
    vertical-align:middle;
}
.data-table tr:last-child td { border-bottom:none; }
.data-table tr:hover td      { background:rgba(255,255,255,0.02); }
.avatar {
    width:36px; height:36px; border-radius:50%;
    background: linear-gradient(135deg, #f0a500, #cf8d00);
    display:flex; align-items:center; justify-content:center;
    font-weight:700; color:#1a1a1a; font-size:0.85rem; flex-shrink:0;
}
.user-cell { display:flex; align-items:center; gap:10px; }
.rating-stars { color:var(--primary); font-size:1rem; letter-spacing:2px; }
.comment-text {
    color: rgba(255,255,255,0.7);
    font-style:italic;
    font-size:0.88rem;
    max-width:320px;
}
.rating-badge {
    display:inline-flex; align-items:center; gap:5px;
    padding:4px 10px; border-radius:50px; font-size:0.8rem; font-weight:700;
}
.rating-5 { background:rgba(34,197,94,0.15); color:#22c55e; }
.rating-4 { background:rgba(59,130,246,0.15); color:#3b82f6; }
.rating-3 { background:rgba(234,179,8,0.15); color:#eab308; }
.rating-2 { background:rgba(249,115,22,0.15); color:#f97316; }
.rating-1 { background:rgba(239,68,68,0.15); color:#ef4444; }
.empty-state { text-align:center; padding:50px; color:var(--text-muted); }
</style>

<div class="page-header">
    <div>
        <h1 class="page-title">⭐ Kelola Testimoni</h1>
        <p class="page-sub">Pantau ulasan dan rating dari pelanggan</p>
    </div>
</div>

{{-- Summary Strip --}}
@php
    $avg = $testimonials->count() > 0 ? number_format($testimonials->avg('rating'), 1) : '0.0';
    $bintang5 = $testimonials->where('rating', 5)->count();
    $bintang4 = $testimonials->where('rating', 4)->count();
    $bintang3 = $testimonials->where('rating', 3)->count();
@endphp
<div class="summary-strip">
    <div class="strip-card">
        <div class="strip-num">{{ $testimonials->count() }}</div>
        <div class="strip-label">Total Ulasan</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#22c55e;">{{ $avg }}</div>
        <div class="strip-label">Rata-rata Rating</div>
    </div>
    <div class="strip-card">
        <div class="strip-num">{{ $bintang5 }}</div>
        <div class="strip-label">Bintang 5 ⭐</div>
    </div>
    <div class="strip-card">
        <div class="strip-num">{{ $bintang4 }}</div>
        <div class="strip-label">Bintang 4 ⭐</div>
    </div>
    <div class="strip-card">
        <div class="strip-num" style="color:#eab308;">{{ $bintang3 }}</div>
        <div class="strip-label">Bintang ≤ 3</div>
    </div>
</div>

<div class="panel-card">
    <div class="panel-header">
        <span style="font-weight:700;">Daftar Ulasan Pelanggan</span>
        <span style="background:rgba(240,165,0,0.1); color:var(--primary); font-size:0.8rem; font-weight:600; padding:4px 12px; border-radius:50px;">{{ $testimonials->count() }} ulasan</span>
    </div>

    @if($testimonials->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Rating</th>
                <th>Komentar</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($testimonials as $t)
            <tr>
                <td>
                    <div class="user-cell">
                        <div class="avatar">{{ strtoupper(substr($t->user->name ?? 'A', 0, 1)) }}</div>
                        <div>
                            <div style="font-weight:600; font-size:0.9rem;">{{ $t->user->name ?? 'Pelanggan' }}</div>
                            <div style="color:var(--text-muted); font-size:0.78rem;">{{ $t->user->email ?? '' }}</div>
                        </div>
                    </div>
                </td>
                <td>
                    @php $rClass = 'rating-' . $t->rating; @endphp
                    <span class="rating-badge {{ $rClass }}">
                        {{ $t->rating }}/5 ★
                    </span>
                    <div class="rating-stars" style="font-size:0.85rem; margin-top:4px;">
                        @for($i = 1; $i <= 5; $i++)
                            {{ $i <= $t->rating ? '★' : '☆' }}
                        @endfor
                    </div>
                </td>
                <td>
                    <div class="comment-text">"{{ $t->komentar }}"</div>
                </td>
                <td style="color:var(--text-muted); font-size:0.85rem; white-space:nowrap;">
                    {{ $t->created_at->format('d M Y') }}<br>
                    <span style="font-size:0.78rem;">{{ $t->created_at->diffForHumans() }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="empty-state">
            <div style="font-size:48px; margin-bottom:12px;">⭐</div>
            <p style="font-weight:600;">Belum Ada Ulasan</p>
            <p style="font-size:0.85rem; margin-top:4px;">Pelanggan belum memberikan testimoni.</p>
        </div>
    @endif
</div>
@endsection
