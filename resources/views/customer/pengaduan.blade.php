@extends('layouts.app')

@section('content')
<style>
.pengaduan-layout {
    display: grid;
    grid-template-columns: 1fr 320px;
    gap: 30px;
    max-width: 1000px;
    margin: 30px auto 60px;
    align-items: start;
}
.form-card {
    background: var(--card-bg);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.07);
    overflow: hidden;
}
.form-card-header {
    padding: 24px 28px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    background: linear-gradient(135deg, rgba(239,68,68,0.06), transparent);
}
.form-card-header h2 { font-size: 1.2rem; font-weight: 700; }
.form-card-header p  { color: var(--text-muted); font-size: 0.88rem; margin-top: 4px; }
.form-card-body { padding: 28px; }
.form-label {
    display: block;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 10px;
}
.form-input {
    width: 100%;
    padding: 13px 16px;
    border-radius: 12px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.04);
    color: var(--text-light);
    font-size: 0.95rem;
    transition: 0.2s;
    font-family: inherit;
}
.form-input:focus {
    outline: none;
    border-color: #ef4444;
    background: rgba(239,68,68,0.03);
}
.form-input::placeholder { color: rgba(255,255,255,0.3); }
.mb-20 { margin-bottom: 20px; }
/* Kategori Chips */
.kategori-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 20px;
}
.chip {
    padding: 7px 14px;
    border-radius: 50px;
    border: 1px solid rgba(255,255,255,0.12);
    background: transparent;
    color: var(--text-muted);
    font-size: 0.82rem;
    cursor: pointer;
    transition: 0.2s;
    font-family: inherit;
}
.chip.active, .chip:hover {
    background: rgba(239,68,68,0.12);
    border-color: rgba(239,68,68,0.4);
    color: #ef4444;
}
.btn-submit {
    width: 100%;
    padding: 14px;
    background: #ef4444;
    color: white;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    margin-top: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}
.btn-submit:hover {
    background: #dc2626;
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(239,68,68,0.3);
}
/* Panel Info */
.info-panel { display: flex; flex-direction: column; gap: 16px; }
.info-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.07);
    padding: 20px;
}
.info-item {
    display: flex;
    gap: 14px;
    padding: 14px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    align-items: flex-start;
}
.info-item:last-child { border-bottom: none; padding-bottom: 0; }
.info-item:first-child { padding-top: 0; }
.info-icon {
    width: 40px; height: 40px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; flex-shrink: 0;
}
.info-text-title { font-weight: 600; font-size: 0.9rem; margin-bottom: 3px; }
.info-text-sub   { color: var(--text-muted); font-size: 0.82rem; line-height: 1.5; }
.alert-success {
    background: rgba(34,197,94,0.1);
    border: 1px solid rgba(34,197,94,0.3);
    color: #22c55e;
    padding: 14px 18px;
    border-radius: 12px;
    margin-bottom: 20px;
    font-size: 0.9rem;
}
@media (max-width: 768px) {
    .pengaduan-layout { grid-template-columns: 1fr; }
}
</style>

<div class="pengaduan-layout">
    {{-- KIRI: Form --}}
    <div>
        <div class="form-card">
            <div class="form-card-header">
                <h2>📢 Pengaduan / Hubungi Kami</h2>
                <p>Sampaikan keluhan atau pertanyaan Anda. Kami akan merespons sesegera mungkin.</p>
            </div>
            <div class="form-card-body">

                @if(session('success'))
                    <div class="alert-success">✓ {{ session('success') }}</div>
                @endif

                <form method="POST" action="/pengaduan">
                    @csrf

                    {{-- Kategori cepat --}}
                    <div class="mb-20">
                        <label class="form-label">Kategori Pengaduan</label>
                        <div class="kategori-chips">
                            <button type="button" class="chip" onclick="setSubjek(this, 'Pesanan Terlambat')">🕐 Pesanan Terlambat</button>
                            <button type="button" class="chip" onclick="setSubjek(this, 'Kualitas Makanan')">🍽️ Kualitas Makanan</button>
                            <button type="button" class="chip" onclick="setSubjek(this, 'Kemasan Rusak')">📦 Kemasan Rusak</button>
                            <button type="button" class="chip" onclick="setSubjek(this, 'Pertanyaan Umum')">❓ Pertanyaan Umum</button>
                            <button type="button" class="chip" onclick="setSubjek(this, 'Lainnya')">📝 Lainnya</button>
                        </div>
                    </div>

                    {{-- Subjek --}}
                    <div class="mb-20">
                        <label class="form-label" for="subjek">Subjek</label>
                        <input type="text" name="subjek" id="subjek" class="form-input"
                            required placeholder="Tuliskan subjek pengaduan Anda..." value="{{ old('subjek') }}">
                    </div>

                    {{-- Isi Keluhan --}}
                    <div class="mb-20">
                        <label class="form-label" for="isi_keluhan">Detail Pengaduan</label>
                        <textarea name="isi_keluhan" id="isi_keluhan" class="form-input"
                            rows="6" required
                            placeholder="Jelaskan detail pengaduan Anda dengan lengkap — apa yang terjadi, kapan, dan apa yang Anda harapkan...">{{ old('isi_keluhan') }}</textarea>
                    </div>

                    {{-- Info User --}}
                    <div style="background: rgba(255,255,255,0.03); border-radius: 10px; padding: 14px 16px; display:flex; align-items:center; gap:12px; border: 1px solid rgba(255,255,255,0.06);">
                        <div style="width:36px; height:36px; border-radius:50%; background: #ef4444; display:flex; align-items:center; justify-content:center; font-weight:700; color:white; font-size:0.9rem; flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:0.9rem;">{{ auth()->user()->name }}</div>
                            <div style="color:var(--text-muted); font-size:0.8rem;">{{ auth()->user()->email }}</div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        📤 Kirim Pengaduan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- KANAN: Info --}}
    <div class="info-panel">
        <div class="info-card">
            <div style="font-weight:700; font-size:1rem; margin-bottom:4px;">📞 Informasi Kontak</div>
            <div style="color:var(--text-muted); font-size:0.85rem; margin-bottom:16px;">Anda juga bisa menghubungi kami melalui:</div>

            <div class="info-item">
                <div class="info-icon" style="background: rgba(240,165,0,0.1);">📱</div>
                <div>
                    <div class="info-text-title">WhatsApp</div>
                    <div class="info-text-sub">+62 812-3456-7890<br>Senin–Sabtu, 08.00–20.00 WIT</div>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon" style="background: rgba(59,130,246,0.1);">✉️</div>
                <div>
                    <div class="info-text-title">Email</div>
                    <div class="info-text-sub">support@jinemo.com<br>Dibalas dalam 1×24 jam</div>
                </div>
            </div>
            <div class="info-item">
                <div class="info-icon" style="background: rgba(34,197,94,0.1);">📍</div>
                <div>
                    <div class="info-text-title">Lokasi</div>
                    <div class="info-text-sub">Jl. Raya Nusantara No. 88<br>Ambon, Maluku</div>
                </div>
            </div>
        </div>

        <div class="info-card">
            <div style="font-weight:700; font-size:1rem; margin-bottom:12px;">⏱ Waktu Respons</div>
            <div style="display:flex; flex-direction:column; gap:10px;">
                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.88rem;">
                    <span style="color:var(--text-muted);">Pengaduan Online</span>
                    <span style="font-weight:600; color:#22c55e;">1×24 jam</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.88rem;">
                    <span style="color:var(--text-muted);">Jam Operasional</span>
                    <span style="font-weight:600;">08.00–20.00</span>
                </div>
                <div style="display:flex; justify-content:space-between; align-items:center; font-size:0.88rem;">
                    <span style="color:var(--text-muted);">Status Layanan</span>
                    <span style="color:#22c55e; font-weight:600;">● Online</span>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function setSubjek(btn, text) {
    document.getElementById('subjek').value = text;
    document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
    btn.classList.add('active');
}
</script>
@endsection
