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
/* ===== Kartu Profil Kiri ===== */
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
    position: relative;
}
.profil-avatar-wrap {
    padding: 0 24px;
    margin-top: -44px;
    margin-bottom: 16px;
}
.profil-avatar {
    width: 88px; height: 88px;
    border-radius: 50%;
    border: 4px solid var(--card-bg);
    background: #1a1a1a;
    display: flex; align-items: center; justify-content: center;
    font-size: 36px; font-weight: 800; color: var(--primary);
}
.profil-name { font-size: 1.2rem; font-weight: 700; padding: 0 24px; }
.profil-email { color: var(--text-muted); font-size: 0.88rem; padding: 2px 24px 16px; }
.divider { height: 1px; background: rgba(255,255,255,0.06); }
.info-row {
    display: flex; justify-content: space-between; align-items: center;
    padding: 13px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.04);
    font-size: 0.88rem;
}
.info-row:last-child { border-bottom: none; }
.info-row span:first-child { color: var(--text-muted); }
.info-row span:last-child  { font-weight: 600; }
.poin-box {
    margin: 16px 20px;
    background: rgba(240,165,0,0.1);
    border: 1px solid rgba(240,165,0,0.2);
    border-radius: 14px;
    padding: 18px;
    text-align: center;
}
.poin-number { font-size: 2.5rem; font-weight: 800; color: var(--primary); line-height: 1; }
.poin-label  { color: var(--text-muted); font-size: 0.82rem; margin-top: 4px; }
.poin-bar-wrap { margin-top: 10px; background: rgba(255,255,255,0.08); border-radius: 50px; height: 6px; overflow: hidden; }
.poin-bar { height: 100%; background: var(--primary); border-radius: 50px; transition: width 1s ease; }
.poin-next { font-size: 0.75rem; color: var(--text-muted); margin-top: 6px; }

/* ===== Tabs ===== */
.tabs { display: flex; gap: 4px; background: rgba(255,255,255,0.04); border-radius: 12px; padding: 4px; margin-bottom: 24px; }
.tab-btn {
    flex: 1; padding: 10px; border-radius: 10px; border: none;
    background: transparent; color: var(--text-muted); font-size: 0.9rem;
    font-weight: 600; cursor: pointer; transition: 0.2s; font-family: inherit;
}
.tab-btn.active { background: var(--card-bg); color: var(--text-light); }
.tab-content { display: none; }
.tab-content.active { display: block; }

/* ===== Panel ===== */
.panel-card { background: var(--card-bg); border-radius: 16px; border: 1px solid rgba(255,255,255,0.07); overflow: hidden; margin-bottom: 20px; }
.panel-hdr  { padding: 18px 24px; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center; }
.panel-hdr-title { font-weight: 700; font-size: 1rem; }
.panel-badge { background: rgba(240,165,0,0.1); color: var(--primary); font-size: 0.78rem; font-weight: 600; padding: 3px 10px; border-radius: 50px; }

/* ===== Riwayat ===== */
.order-card {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    transition: 0.2s;
}
.order-card:last-child { border-bottom: none; }
.order-card:hover { background: rgba(255,255,255,0.02); }
.order-top { display: flex; justify-content: space-between; align-items: flex-start; gap: 12px; margin-bottom: 14px; flex-wrap: wrap; }
.order-id { font-family: monospace; font-weight: 700; color: var(--primary); font-size: 1rem; }
.order-date { color: var(--text-muted); font-size: 0.82rem; margin-top: 2px; }
.status-badge { display: inline-flex; align-items: center; gap: 5px; padding: 5px 12px; border-radius: 50px; font-size: 0.82rem; font-weight: 600; }
.status-pending  { background: rgba(234,179,8,0.15); color: #eab308; }
.status-selesai  { background: rgba(34,197,94,0.15); color: #22c55e; }
.status-diproses { background: rgba(59,130,246,0.15); color: #3b82f6; }
.status-batal    { background: rgba(239,68,68,0.15); color: #ef4444; }

/* Timeline status */
.status-timeline { display: flex; align-items: center; gap: 0; margin: 14px 0 8px; }
.timeline-step {
    display: flex; flex-direction: column; align-items: center; flex: 1;
}
.timeline-dot {
    width: 28px; height: 28px; border-radius: 50%;
    border: 2px solid rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; background: var(--bg); position: relative; z-index: 1;
}
.timeline-dot.done   { background: #22c55e; border-color: #22c55e; color: white; }
.timeline-dot.active { background: var(--primary); border-color: var(--primary); color: #1a1a1a; }
.timeline-label { font-size: 0.72rem; color: var(--text-muted); margin-top: 5px; text-align: center; }
.timeline-label.done   { color: #22c55e; }
.timeline-label.active { color: var(--primary); font-weight: 600; }
.timeline-line {
    flex: 1; height: 2px; background: rgba(255,255,255,0.1);
    margin-top: -16px;
}
.timeline-line.done { background: #22c55e; }

.order-footer {
    display: flex; justify-content: space-between; align-items: center;
    margin-top: 14px; padding-top: 14px;
    border-top: 1px solid rgba(255,255,255,0.05);
}
.order-total-label { color: var(--text-muted); font-size: 0.82rem; }
.order-total-val   { font-size: 1.15rem; font-weight: 800; color: var(--text-light); }
.order-poin { background: rgba(240,165,0,0.1); color: var(--primary); font-size: 0.78rem; font-weight: 600; padding: 4px 10px; border-radius: 50px; }

/* ===== Edit Profil Form ===== */
.form-label  { display: block; font-size: 0.82rem; font-weight: 600; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 9px; }
.form-input  { width: 100%; padding: 12px 16px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); background: rgba(255,255,255,0.04); color: var(--text-light); font-size: 0.95rem; transition: 0.2s; font-family: inherit; }
.form-input:focus { outline: none; border-color: var(--primary); background: rgba(240,165,0,0.03); }
.form-input:disabled { opacity: 0.5; cursor: not-allowed; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 18px; }
.btn-save { padding: 13px 24px; background: var(--primary); color: #1a1a1a; border: none; border-radius: 12px; font-size: 0.95rem; font-weight: 700; cursor: pointer; transition: all 0.3s; }
.btn-save:hover { background: var(--primary-dark); transform: translateY(-1px); box-shadow: 0 6px 16px rgba(240,165,0,0.3); }

/* ===== Favorit ===== */
.fav-item { display: flex; align-items: center; gap: 16px; padding: 16px 24px; border-bottom: 1px solid rgba(255,255,255,0.04); transition: 0.2s; }
.fav-item:last-child { border-bottom: none; }
.fav-item:hover { background: rgba(255,255,255,0.02); }
.fav-icon { width: 50px; height: 50px; background: rgba(240,165,0,0.1); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; flex-shrink: 0; }

/* ===== Notif ===== */
.alert-success { background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #22c55e; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.88rem; }
.empty-state { text-align: center; padding: 48px 20px; color: var(--text-muted); }

@media (max-width: 768px) {
    .profil-layout { grid-template-columns: 1fr; }
    .profil-card   { position: static; }
    .form-grid     { grid-template-columns: 1fr; }
}
</style>

<div class="profil-layout">

    {{-- ===== KIRI: Kartu Profil ===== --}}
    <div class="profil-card">
        <div class="profil-banner"></div>
        <div class="profil-avatar-wrap">
            @if(auth()->user()->foto)
                <div class="profil-avatar" style="padding:0; overflow:hidden;">
                    <img src="{{ Storage::url(auth()->user()->foto) }}" alt="Foto Profil"
                         style="width:100%; height:100%; object-fit:cover; border-radius:50%;">
                </div>
            @else
                <div class="profil-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            @endif
        </div>
        <div class="profil-name">{{ auth()->user()->name }}</div>
        <div class="profil-email">{{ auth()->user()->email }}</div>

        <div class="divider"></div>

        <div class="info-row">
            <span>Status Akun</span>
            <span style="color:#22c55e; display:flex; align-items:center; gap:5px;">
                <span style="width:7px; height:7px; border-radius:50%; background:#22c55e; display:inline-block;"></span> Aktif
            </span>
        </div>
        <div class="info-row">
            <span>Tipe Akun</span>
            <span style="text-transform:capitalize; background:rgba(240,165,0,0.1); color:var(--primary); padding:2px 10px; border-radius:50px; font-size:0.8rem;">{{ auth()->user()->role }}</span>
        </div>
        <div class="info-row">
            <span>Bergabung</span>
            <span>{{ auth()->user()->created_at->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span>Total Pesanan</span>
            <span>{{ $orders->count() }} pesanan</span>
        </div>
        <div class="info-row">
            <span>Pesanan Selesai</span>
            <span style="color:#22c55e;">{{ $orders->where('status','Selesai')->count() }} selesai</span>
        </div>

        {{-- Loyalty Points --}}
        <div class="poin-box">
            <div class="poin-number">{{ auth()->user()->point }}</div>
            <div class="poin-label">Loyalty Points</div>
            @php $persen = min(100, (auth()->user()->point % 100)); @endphp
            <div class="poin-bar-wrap">
                <div class="poin-bar" style="width: {{ $persen }}%;"></div>
            </div>
            <div class="poin-next">+10 poin setiap pesan • Level up di 100 poin</div>
        </div>

        {{-- Link navigasi cepat --}}
        <div style="padding: 0 16px 16px; display:flex; flex-direction:column; gap:8px;">
            <a href="/keranjang" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--text-muted); font-size:0.88rem; transition:0.2s;"
               onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.color='var(--text-light)'"
               onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'">
                🛒 Keranjang Saya
            </a>
            <a href="/testimoni" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--text-muted); font-size:0.88rem; transition:0.2s;"
               onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.color='var(--text-light)'"
               onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'">
                ⭐ Tulis Ulasan
            </a>
            <a href="/pengaduan" style="display:flex; align-items:center; gap:10px; padding:10px 12px; border-radius:10px; color:var(--text-muted); font-size:0.88rem; transition:0.2s;"
               onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.color='var(--text-light)'"
               onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'">
                📢 Buat Pengaduan
            </a>
        </div>
    </div>

    {{-- ===== KANAN ===== --}}
    <div>
        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        {{-- Tabs --}}
        <div class="tabs">
            <button class="tab-btn active" onclick="switchTab('riwayat', this)">📋 Riwayat Transaksi</button>
            <button class="tab-btn" onclick="switchTab('edit', this)">✏️ Edit Profil</button>
            <button class="tab-btn" onclick="switchTab('favorit', this)">♡ Favorit</button>
        </div>

        {{-- ===== Tab 1: Riwayat ===== --}}
        <div id="tab-riwayat" class="tab-content active">
            <div class="panel-card">
                <div class="panel-hdr">
                    <span class="panel-hdr-title">📋 Riwayat Transaksi</span>
                    <span class="panel-badge">{{ $orders->count() }} transaksi</span>
                </div>

                @if($orders->count() > 0)
                    @foreach($orders as $order)
                    @php
                        $status = strtolower($order->status);
                        $statusClass = match($status) {
                            'selesai'  => 'status-selesai',
                            'diproses' => 'status-diproses',
                            'batal'    => 'status-batal',
                            default    => 'status-pending',
                        };
                        $statusIcon = match($status) {
                            'selesai'  => '✓',
                            'diproses' => '⟳',
                            'batal'    => '✕',
                            default    => '⏳',
                        };
                        // Timeline: Pending > Diproses > Selesai
                        $step1 = true;  // Pesanan Masuk selalu done
                        $step2 = in_array($status, ['diproses', 'selesai']);
                        $step3 = $status === 'selesai';
                    @endphp
                    <div class="order-card">
                        <div class="order-top">
                            <div>
                                <div class="order-id">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="order-date">{{ $order->created_at->format('d M Y') }} • {{ $order->created_at->format('H:i') }} WIT</div>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <span class="status-badge {{ $statusClass }}">{{ $statusIcon }} {{ $order->status }}</span>
                                @if($status === 'selesai')
                                    <span class="order-poin">+10 pts</span>
                                @endif
                            </div>
                        </div>

                        {{-- Status Timeline --}}
                        @if($status !== 'batal')
                        <div class="status-timeline">
                            {{-- Step 1 --}}
                            <div class="timeline-step">
                                <div class="timeline-dot done">✓</div>
                                <div class="timeline-label done">Dipesan</div>
                            </div>
                            <div class="timeline-line {{ $step2 ? 'done' : '' }}"></div>
                            {{-- Step 2 --}}
                            <div class="timeline-step">
                                <div class="timeline-dot {{ $step2 ? ($step3 ? 'done' : 'active') : '' }}">{{ $step2 ? ($step3 ? '✓' : '⟳') : '2' }}</div>
                                <div class="timeline-label {{ $step2 ? ($step3 ? 'done' : 'active') : '' }}">Diproses</div>
                            </div>
                            <div class="timeline-line {{ $step3 ? 'done' : '' }}"></div>
                            {{-- Step 3 --}}
                            <div class="timeline-step">
                                <div class="timeline-dot {{ $step3 ? 'done' : '' }}">{{ $step3 ? '✓' : '3' }}</div>
                                <div class="timeline-label {{ $step3 ? 'done' : '' }}">Selesai</div>
                            </div>
                        </div>
                        @else
                        <div style="display:flex; align-items:center; gap:8px; padding:10px 0; color:#ef4444; font-size:0.85rem;">
                            <span>✕</span> <span>Pesanan ini telah dibatalkan</span>
                        </div>
                        @endif

                        <div class="order-footer">
                            <div>
                                <div class="order-total-label">Total Pembayaran</div>
                                <div class="order-total-val">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</div>
                            </div>
                            @if($status === 'selesai')
                            <a href="/testimoni" style="padding:8px 16px; border-radius:10px; background:rgba(240,165,0,0.1); color:var(--primary); font-size:0.82rem; font-weight:600; text-decoration:none; border:1px solid rgba(240,165,0,0.2);">
                                ⭐ Beri Ulasan
                            </a>
                            @elseif($status === 'pending')
                            <a href="/produk" style="padding:8px 16px; border-radius:10px; background:rgba(255,255,255,0.05); color:var(--text-muted); font-size:0.82rem; font-weight:600; text-decoration:none;">
                                🛒 Pesan Lagi
                            </a>
                            @endif
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div style="font-size:56px; margin-bottom:14px;">📦</div>
                        <p style="font-weight:700; font-size:1rem; margin-bottom:6px;">Belum Ada Pesanan</p>
                        <p style="font-size:0.88rem;">Mulai pesan menu favorit Anda sekarang!</p>
                        <a href="/produk" class="btn btn-primary" style="display:inline-block; margin-top:20px;">Lihat Menu</a>
                    </div>
                @endif
            </div>
        </div>

        {{-- ===== Tab 2: Edit Profil ===== --}}
        <div id="tab-edit" class="tab-content">
            <div class="panel-card">
                <div class="panel-hdr">
                    <span class="panel-hdr-title">✏️ Data Akun</span>
                </div>
                <div style="padding: 28px;">
                    <form method="POST" action="/profil/update" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- Upload Foto --}}
                        <div style="margin-bottom:24px;">
                            <label class="form-label">Foto Profil</label>
                            <div style="display:flex; align-items:center; gap:20px;">
                                <div id="foto-preview" style="width:80px; height:80px; border-radius:50%; overflow:hidden; background:rgba(255,255,255,0.05); border:2px dashed rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                    @if(auth()->user()->foto)
                                        <img src="{{ Storage::url(auth()->user()->foto) }}" id="preview-img" style="width:100%; height:100%; object-fit:cover;">
                                    @else
                                        <span id="preview-placeholder" style="font-size:28px; color:var(--text-muted);">👤</span>
                                        <img id="preview-img" src="" style="display:none; width:100%; height:100%; object-fit:cover;">
                                    @endif
                                </div>
                                <div style="flex:1;">
                                    <label for="foto-input" style="display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.04); cursor:pointer; font-size:0.88rem; color:var(--text-light); transition:0.2s;"
                                        onmouseover="this.style.borderColor='var(--primary)'; this.style.color='var(--primary)'"
                                        onmouseout="this.style.borderColor='rgba(255,255,255,0.15)'; this.style.color='var(--text-light)'">
                                        📷 Pilih Foto
                                    </label>
                                    <input type="file" id="foto-input" name="foto" accept="image/*" style="display:none;" onchange="previewFoto(this)">
                                    <p style="color:var(--text-muted); font-size:0.78rem; margin-top:8px;">JPG, PNG. Maks 2MB.</p>
                                </div>
                            </div>
                        </div>

                        <div class="form-grid" style="margin-bottom: 20px;">
                            <div>
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-input" value="{{ auth()->user()->name }}" required>
                            </div>
                            <div>
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-input" value="{{ auth()->user()->email }}" disabled style="opacity:0.5; cursor:not-allowed;">
                                <p style="font-size:0.75rem; color:var(--text-muted); margin-top:5px;">Email tidak dapat diubah.</p>
                            </div>
                        </div>

                        <div style="margin-bottom: 24px;">
                            <label class="form-label">Bergabung Sejak</label>
                            <input type="text" class="form-input" value="{{ auth()->user()->created_at->format('d F Y') }}" disabled style="opacity:0.5; cursor:not-allowed;">
                        </div>

                        <div class="divider" style="margin-bottom:24px;"></div>

                        <p style="font-weight:700; margin-bottom:16px; font-size:0.95rem;">🔒 Ganti Password</p>
                        <div class="form-grid" style="margin-bottom:20px;">
                            <div>
                                <label class="form-label">Password Baru</label>
                                <input type="password" name="password" class="form-input" placeholder="Kosongkan jika tidak diubah">
                            </div>
                            <div>
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                            </div>
                        </div>

                        <div style="display:flex; gap:12px; justify-content:flex-end;">
                            <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- ===== Tab 3: Favorit ===== --}}
        <div id="tab-favorit" class="tab-content">
            <div class="panel-card">
                <div class="panel-hdr">
                    <span class="panel-hdr-title">♡ Menu Favorit Saya</span>
                    <span class="panel-badge">{{ $favorites->count() }} item</span>
                </div>
                @if($favorites->count() > 0)
                    @foreach($favorites as $fav)
                    <div class="fav-item">
                        <div class="fav-icon">🍽️</div>
                        <div style="flex:1;">
                            <div style="font-weight:600; font-size:0.95rem; margin-bottom:2px;">{{ $fav->nama_produk }}</div>
                            <div style="font-size:0.8rem; color:var(--text-muted);">Menu favorit Anda</div>
                        </div>
                        <a href="/keranjang/tambah/{{ $fav->product_id }}" style="padding:8px 16px; border-radius:10px; background:rgba(240,165,0,0.1); color:var(--primary); font-size:0.82rem; font-weight:600; text-decoration:none; border:1px solid rgba(240,165,0,0.2); cursor:pointer;">
                            🛒 Pesan
                        </a>
                    </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div style="font-size:56px; margin-bottom:14px;">♡</div>
                        <p style="font-weight:700; font-size:1rem; margin-bottom:6px;">Belum Ada Favorit</p>
                        <p style="font-size:0.88rem;">Tambahkan menu ke favorit dari halaman detail produk.</p>
                        <a href="/produk" class="btn btn-primary" style="display:inline-block; margin-top:20px;">Jelajahi Menu</a>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>

<script>
function switchTab(name, btn) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + name).classList.add('active');
    btn.classList.add('active');
}

function previewFoto(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const img = document.getElementById('preview-img');
            const placeholder = document.getElementById('preview-placeholder');
            img.src = e.target.result;
            img.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
