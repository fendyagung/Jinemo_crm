@extends('layouts.admin')

@section('content')
<style>
.profil-layout { display:grid; grid-template-columns:280px 1fr; gap:24px; max-width:1000px; }
/* Kartu kiri */
.profil-card { background:var(--card-bg); border-radius:20px; border:1px solid rgba(255,255,255,0.07); overflow:hidden; position:sticky; top:90px; }
.profil-banner { height:80px; background:linear-gradient(135deg,#f0a500,#cf8d00); }
.avatar-wrap { padding:0 24px; margin-top:-40px; margin-bottom:14px; position:relative; z-index:10; }
.avatar-img {
    width:80px; height:80px; border-radius:50%;
    border:4px solid var(--card-bg);
    overflow:hidden;
    background:#1a1a1a;
    display:flex; align-items:center; justify-content:center;
    font-size:32px; font-weight:800; color:var(--primary);
}
.avatar-img img { width:100%; height:100%; object-fit:cover; }
.admin-name  { font-size:1.1rem; font-weight:700; padding:0 24px; }
.admin-email { color:var(--text-muted); font-size:0.85rem; padding:2px 24px 14px; }
.divider { height:1px; background:rgba(255,255,255,0.06); }
.info-row { display:flex; justify-content:space-between; align-items:center; padding:12px 24px; border-bottom:1px solid rgba(255,255,255,0.04); font-size:0.85rem; }
.info-row:last-child { border-bottom:none; }
.info-row span:first-child { color:var(--text-muted); }
.info-row span:last-child  { font-weight:600; }
.admin-badge { background:linear-gradient(135deg,#f0a500,#cf8d00); color:#1a1a1a; font-size:0.78rem; font-weight:700; padding:3px 10px; border-radius:50px; }

/* Kanan */
.panel-card { background:var(--card-bg); border-radius:16px; border:1px solid rgba(255,255,255,0.07); overflow:hidden; margin-bottom:20px; }
.panel-hdr  { padding:18px 24px; border-bottom:1px solid rgba(255,255,255,0.05); font-weight:700; font-size:0.95rem; display:flex; align-items:center; gap:10px; }
.panel-body { padding:28px; }
.form-label { display:block; font-size:0.8rem; font-weight:600; color:var(--text-muted); text-transform:uppercase; letter-spacing:0.5px; margin-bottom:9px; }
.form-input { width:100%; padding:12px 16px; border-radius:12px; border:1px solid rgba(255,255,255,0.1); background:rgba(255,255,255,0.04); color:var(--text-light); font-size:0.95rem; transition:0.2s; font-family:inherit; }
.form-input:focus { outline:none; border-color:var(--primary); background:rgba(240,165,0,0.03); }
.form-input:disabled { opacity:0.5; cursor:not-allowed; }
.form-grid { display:grid; grid-template-columns:1fr 1fr; gap:18px; margin-bottom:20px; }
.divider-sm { height:1px; background:rgba(255,255,255,0.06); margin:24px 0; }
.btn-save { padding:12px 24px; background:var(--primary); color:#1a1a1a; border:none; border-radius:12px; font-size:0.92rem; font-weight:700; cursor:pointer; transition:all 0.3s; }
.btn-save:hover { background:var(--primary-dark); transform:translateY(-1px); box-shadow:0 6px 16px rgba(240,165,0,0.3); }

/* Foto upload */
.foto-preview { width:80px; height:80px; border-radius:50%; overflow:hidden; background:rgba(255,255,255,0.05); border:2px dashed rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; font-size:28px; flex-shrink:0; }
.foto-preview img { width:100%; height:100%; object-fit:cover; }
.btn-pilih-foto { display:inline-flex; align-items:center; gap:8px; padding:10px 18px; border-radius:10px; border:1px solid rgba(255,255,255,0.15); background:rgba(255,255,255,0.04); cursor:pointer; font-size:0.88rem; color:var(--text-light); transition:0.2s; }
.btn-pilih-foto:hover { border-color:var(--primary); color:var(--primary); }

/* Stats mini */
.mini-stats { display:grid; grid-template-columns:repeat(4,1fr); gap:14px; }
.mini-stat { background:rgba(255,255,255,0.03); border-radius:12px; border:1px solid rgba(255,255,255,0.06); padding:16px; text-align:center; }
.mini-stat-num   { font-size:1.6rem; font-weight:800; color:var(--primary); }
.mini-stat-label { font-size:0.78rem; color:var(--text-muted); margin-top:3px; }

/* Alert */
.alert-success { background:rgba(34,197,94,0.1); border:1px solid rgba(34,197,94,0.3); color:#22c55e; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:0.9rem; }

@media (max-width:768px) {
    .profil-layout { grid-template-columns:1fr; }
    .profil-card   { position:static; }
    .form-grid     { grid-template-columns:1fr; }
    .mini-stats    { grid-template-columns:repeat(2,1fr); }
}
</style>

<div class="profil-layout">

    {{-- KIRI: Kartu Admin --}}
    <div class="profil-card">
        <div class="profil-banner"></div>
        <div class="avatar-wrap">
            <div class="avatar-img">
                @if(auth()->user()->foto)
                    <img src="{{ Storage::url(auth()->user()->foto) }}" alt="Foto Admin">
                @else
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                @endif
            </div>
        </div>
        <div class="admin-name">{{ auth()->user()->name }}</div>
        <div class="admin-email">{{ auth()->user()->email }}</div>

        <div class="divider"></div>

        <div class="info-row">
            <span>Status</span>
            <span style="color:#22c55e; display:flex; align-items:center; gap:5px;">
                <span style="width:7px; height:7px; border-radius:50%; background:#22c55e; display:inline-block;"></span> Aktif
            </span>
        </div>
        <div class="info-row">
            <span>Role</span>
            <span class="admin-badge">Administrator</span>
        </div>
        <div class="info-row">
            <span>Bergabung</span>
            <span>{{ auth()->user()->created_at->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span>Last Login</span>
            <span>{{ now()->format('d M Y') }}</span>
        </div>
        <div class="info-row">
            <span>Akses</span>
            <span style="color:var(--primary);">Full Access</span>
        </div>

        {{-- Link admin --}}
        <div style="padding:12px 16px; display:flex; flex-direction:column; gap:4px;">
            @foreach([
                ['/admin/dashboard','📊','Dashboard'],
                ['/admin/laporan','📈','Laporan'],
                ['/admin/pesanan','📦','Pesanan'],
            ] as [$href,$icon,$label])
            <a href="{{ $href }}" style="display:flex; align-items:center; gap:10px; padding:9px 12px; border-radius:10px; color:var(--text-muted); font-size:0.85rem; transition:0.2s; text-decoration:none;"
               onmouseover="this.style.background='rgba(255,255,255,0.05)'; this.style.color='var(--text-light)'"
               onmouseout="this.style.background='transparent'; this.style.color='var(--text-muted)'">
                {{ $icon }} {{ $label }}
            </a>
            @endforeach
        </div>
    </div>

    {{-- KANAN --}}
    <div>
        @if(session('success'))
            <div class="alert-success">✓ {{ session('success') }}</div>
        @endif

        {{-- Statistik cepat --}}
        <div class="panel-card">
            <div class="panel-hdr">📊 Statistik Sistem</div>
            <div class="panel-body">
                <div class="mini-stats">
                    <div class="mini-stat">
                        <div class="mini-stat-num">{{ $stats['pelanggan'] }}</div>
                        <div class="mini-stat-label">👥 Pelanggan</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-num">{{ $stats['produk'] }}</div>
                        <div class="mini-stat-label">🍽️ Menu</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-num">{{ $stats['pesanan'] }}</div>
                        <div class="mini-stat-label">📦 Pesanan</div>
                    </div>
                    <div class="mini-stat">
                        <div class="mini-stat-num">{{ $stats['pengaduan'] }}</div>
                        <div class="mini-stat-label">📢 Pengaduan</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form Edit Profil --}}
        <div class="panel-card">
            <div class="panel-hdr">✏️ Edit Profil Admin</div>
            <div class="panel-body">
                @if($errors->any())
                    <div style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.3); color:#ef4444; padding:12px 18px; border-radius:12px; margin-bottom:20px; font-size:0.9rem;">
                        ✕ {{ $errors->first() }}
                    </div>
                @endif
                <form method="POST" action="/admin/profil/update" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Foto --}}
                    <div style="margin-bottom:24px;">
                        <label class="form-label">Foto Profil</label>
                        <div style="display:flex; align-items:center; gap:20px;">
                            <div class="foto-preview" id="foto-preview">
                                @if(auth()->user()->foto)
                                    <img src="{{ Storage::url(auth()->user()->foto) }}" id="preview-img">
                                @else
                                    <span id="preview-placeholder">👤</span>
                                    <img id="preview-img" src="" style="display:none; width:100%; height:100%; object-fit:cover;">
                                @endif
                            </div>
                            <div>
                                <label for="foto-input" class="btn-pilih-foto">📷 Pilih Foto</label>
                                <input type="file" id="foto-input" name="foto" accept="image/*" style="display:none;" onchange="previewFoto(this)">
                                <p style="color:var(--text-muted); font-size:0.78rem; margin-top:8px;">JPG, PNG. Maks 2MB.</p>
                            </div>
                        </div>
                    </div>

                    {{-- Nama & Email --}}
                    <div class="form-grid">
                        <div>
                            <label class="form-label" for="name">Nama Lengkap</label>
                            <input type="text" id="name" name="name" class="form-input" value="{{ auth()->user()->name }}" required>
                        </div>
                        <div>
                            <label class="form-label">Email</label>
                            <input type="email" class="form-input" value="{{ auth()->user()->email }}" disabled>
                            <p style="font-size:0.75rem; color:var(--text-muted); margin-top:5px;">Email tidak dapat diubah.</p>
                        </div>
                    </div>

                    <div class="divider-sm"></div>
                    <p style="font-weight:700; margin-bottom:16px; font-size:0.92rem;">🔒 Ganti Password</p>

                    <div class="form-grid">
                        <div>
                            <label class="form-label" for="password">Password Baru</label>
                            <input type="password" id="password" name="password" class="form-input" placeholder="Kosongkan jika tidak diubah">
                        </div>
                        <div>
                            <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" placeholder="Ulangi password baru">
                        </div>
                    </div>

                    <div style="display:flex; justify-content:flex-end; margin-top:8px;">
                        <button type="submit" class="btn-save">💾 Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
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
