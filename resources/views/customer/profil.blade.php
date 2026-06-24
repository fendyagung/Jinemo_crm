@extends('layouts.app')

@section('content')
<style>
.profil-layout {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 28px;
    max-width: 1100px;
    margin: 30px auto 60px;
    align-items: start;
}
/* Kartu Profil Kiri */
.profil-card {
    background: var(--card-bg);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.07);
    overflow: hidden;
    position: sticky;
    top: 90px;
}
.profil-banner {
    height: 90px;
    background: linear-gradient(135deg, #f0a500, #cf8d00);
}
.profil-avatar-wrap {
    padding: 0 24px;
    margin-top: -40px;
    margin-bottom: 16px;
}
.profil-avatar {
    width: 80px;
    height: 80px;
    background: var(--card-bg);
    border: 4px solid var(--card-bg);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 36px;
    font-weight: 700;
    color: var(--primary);
    background: #1a1a1a;
}
.profil-name {
    font-size: 1.25rem;
    font-weight: 700;
    padding: 0 24px;
}
.profil-email {
    color: var(--text-muted);
    font-size: 0.9rem;
    padding: 2px 24px 16px;
}
.profil-divider {
    height: 1px;
    background: rgba(255,255,255,0.06);
    margin: 0;
}
.profil-info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-size: 0.9rem;
}
.profil-info-row span:first-child { color: var(--text-muted); }
.profil-info-row span:last-child { font-weight: 600; }
.poin-box {
    margin: 20px 24px;
    background: rgba(240,165,0,0.1);
    border: 1px solid rgba(240,165,0,0.25);
    border-radius: 14px;
    padding: 18px;
    text-align: center;
}
.poin-number {
    font-size: 2.5rem;
    font-weight: 800;
    color: var(--primary);
    line-height: 1;
}
.poin-label {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-top: 4px;
}
.poin-desc {
    font-size: 0.78rem;
    color: var(--text-muted);
    margin-top: 8px;
    padding-top: 8px;
    border-top: 1px solid rgba(255,255,255,0.06);
}
/* Kanan */
.right-panel { display: flex; flex-direction: column; gap: 24px; }
.panel-card {
    background: var(--card-bg);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.07);
    overflow: hidden;
}
.panel-header {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.panel-header h3 {
    font-size: 1.05rem;
    font-weight: 700;
}
.panel-header-badge {
    background: rgba(240,165,0,0.1);
    color: var(--primary);
    font-size: 0.8rem;
    font-weight: 600;
    padding: 4px 12px;
    border-radius: 50px;
}

/* Status Badge */
.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.82rem;
    font-weight: 600;
}
.status-pending {
    background: rgba(234,179,8,0.15);
    color: #eab308;
}
.status-selesai {
    background: rgba(34,197,94,0.15);
    color: #22c55e;
}
.status-batal {
    background: rgba(239,68,68,0.15);
    color: #ef4444;
}
.status-proses {
    background: rgba(59,130,246,0.15);
    color: #3b82f6;
}

/* Tabel Riwayat */
.riwayat-table { width: 100%; border-collapse: collapse; }
.riwayat-table th {
    padding: 14px 24px;
    text-align: left;
    color: var(--text-muted);
    font-size: 0.82rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    background: rgba(255,255,255,0.02);
}
.riwayat-table td {
    padding: 16px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-size: 0.92rem;
    vertical-align: middle;
}
.riwayat-table tr:last-child td { border-bottom: none; }
.riwayat-table tr:hover td { background: rgba(255,255,255,0.02); }
.order-id {
    font-weight: 700;
    color: var(--primary);
    font-family: monospace;
    font-size: 0.9rem;
}
.order-date { color: var(--text-muted); font-size: 0.85rem; }
.order-total { font-weight: 700; font-size: 0.95rem; }

/* Favorit */
.fav-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    transition: 0.2s;
}
.fav-item:last-child { border-bottom: none; }
.fav-item:hover { background: rgba(255,255,255,0.02); }
.fav-icon {
    width: 48px;
    height: 48px;
    background: rgba(240,165,0,0.1);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
.fav-name { font-weight: 600; font-size: 0.95rem; flex: 1; }

/* Empty state */
.empty-state {
    padding: 40px;
    text-align: center;
    color: var(--text-muted);
}
.empty-state-icon { font-size: 48px; margin-bottom: 12px; }
.empty-state p { font-size: 0.9rem; }

@media (max-width: 768px) {
    .profil-layout { grid-template-columns: 1fr; }
    .profil-card { position: static; }
}
</style>

<div class="profil-layout">
    {{-- KIRI: Kartu Profil --}}
    <div class="profil-card">
        <div class="profil-banner"></div>
        <div class="profil-avatar-wrap">
            <div class="profil-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        </div>
        <div class="profil-name">{{ auth()->user()->name }}</div>
        <div class="profil-email">{{ auth()->user()->email }}</div>

        <div class="profil-divider"></div>

        <div class="profil-info-row">
            <span>Status Akun</span>
            <span style="color: #22c55e;">✓ Aktif</span>
        </div>
        <div class="profil-info-row">
            <span>Role</span>
            <span style="text-transform: capitalize;">{{ auth()->user()->role }}</span>
        </div>
        <div class="profil-info-row">
            <span>Bergabung</span>
            <span>{{ auth()->user()->created_at->format('M Y') }}</span>
        </div>
        <div class="profil-info-row">
            <span>Total Pesanan</span>
            <span>{{ $orders->count() }} pesanan</span>
        </div>

        {{-- Poin --}}
        <div class="poin-box">
            <div class="poin-number">{{ auth()->user()->point }}</div>
            <div class="poin-label">Loyalty Points</div>
            <div class="poin-desc">⭐ Dapatkan +10 poin setiap kali memesan</div>
        </div>
    </div>

    {{-- KANAN --}}
    <div class="right-panel">

        {{-- Notif sukses --}}
        @if(session('success'))
        <div style="background: rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); color: #22c55e; padding:12px 18px; border-radius:12px; font-size: 0.9rem;">
            ✓ {{ session('success') }}
        </div>
        @endif

        {{-- Riwayat Transaksi --}}
        <div class="panel-card">
            <div class="panel-header">
                <h3>📋 Riwayat Transaksi</h3>
                <span class="panel-header-badge">{{ $orders->count() }} transaksi</span>
            </div>

            @if($orders->count() > 0)
                <table class="riwayat-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td>
                                <div class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </td>
                            <td>
                                <div>{{ $order->created_at->format('d M Y') }}</div>
                                <div class="order-date">{{ $order->created_at->format('H:i') }} WIT</div>
                            </td>
                            <td>
                                <div class="order-total">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                            </td>
                            <td>
                                @php
                                    $statusClass = match(strtolower($order->status)) {
                                        'selesai'  => 'status-selesai',
                                        'batal'    => 'status-batal',
                                        'diproses' => 'status-proses',
                                        default    => 'status-pending',
                                    };
                                    $statusIcon = match(strtolower($order->status)) {
                                        'selesai'  => '✓',
                                        'batal'    => '✕',
                                        'diproses' => '⟳',
                                        default    => '⏳',
                                    };
                                @endphp
                                <span class="status-badge {{ $statusClass }}">
                                    {{ $statusIcon }} {{ $order->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">📦</div>
                    <p style="font-weight:600; margin-bottom:6px;">Belum Ada Pesanan</p>
                    <p>Anda belum pernah melakukan pemesanan.</p>
                    <a href="/produk" class="btn btn-primary" style="display:inline-block; margin-top:16px;">Lihat Menu</a>
                </div>
            @endif
        </div>

        {{-- Favorit --}}
        <div class="panel-card">
            <div class="panel-header">
                <h3>♡ Menu Favorit</h3>
                <span class="panel-header-badge">{{ $favorites->count() }} item</span>
            </div>

            @if($favorites->count() > 0)
                @foreach($favorites as $fav)
                <div class="fav-item">
                    <div class="fav-icon">🍽️</div>
                    <div class="fav-name">{{ $fav->nama_produk }}</div>
                    <a href="/produk/{{ $fav->product_id }}" class="btn btn-primary" style="padding: 8px 16px; font-size: 0.85rem;">
                        Pesan Lagi
                    </a>
                </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">♡</div>
                    <p style="font-weight:600; margin-bottom:6px;">Belum Ada Favorit</p>
                    <p>Tambahkan menu ke favorit dari halaman detail produk.</p>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
