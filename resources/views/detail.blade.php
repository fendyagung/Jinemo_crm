@extends('layouts.app')

@section('content')
<style>
.product-hero {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 50px;
    align-items: start;
}
.product-image-wrap {
    position: relative;
    border-radius: 16px;
    overflow: hidden;
    background: var(--card-bg);
    aspect-ratio: 1/1;
}
.product-image-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.product-image-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 60px;
    min-height: 400px;
}
.badge-status {
    position: absolute;
    top: 16px;
    left: 16px;
    background: var(--primary);
    color: #1a1a1a;
    font-size: 12px;
    font-weight: 700;
    padding: 4px 12px;
    border-radius: 50px;
}
.product-info {
    display: flex;
    flex-direction: column;
    gap: 20px;
}
.product-name {
    font-size: 2.2rem;
    font-weight: 700;
    line-height: 1.2;
    color: var(--text-light);
}
.product-price {
    font-size: 2rem;
    font-weight: 800;
    color: var(--primary);
}
.product-desc {
    color: var(--text-muted);
    line-height: 1.8;
    font-size: 1rem;
    padding: 20px;
    background: rgba(255,255,255,0.03);
    border-radius: 12px;
    border-left: 3px solid var(--primary);
}
.qty-control {
    display: flex;
    align-items: center;
    gap: 0;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    overflow: hidden;
    width: fit-content;
    border: 1px solid rgba(255,255,255,0.1);
}
.qty-btn {
    background: transparent;
    border: none;
    color: var(--text-light);
    font-size: 1.4rem;
    width: 50px;
    height: 50px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: 0.2s;
}
.qty-btn:hover { background: rgba(240,165,0,0.2); color: var(--primary); }
.qty-input {
    width: 70px;
    height: 50px;
    text-align: center;
    background: transparent;
    border: none;
    border-left: 1px solid rgba(255,255,255,0.1);
    border-right: 1px solid rgba(255,255,255,0.1);
    color: var(--text-light);
    font-size: 1.2rem;
    font-weight: 700;
}
.qty-input:focus { outline: none; }
.subtotal-box {
    background: rgba(240,165,0,0.08);
    border: 1px solid rgba(240,165,0,0.2);
    border-radius: 12px;
    padding: 16px 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}
.subtotal-label { color: var(--text-muted); font-size: 0.9rem; }
.subtotal-value { font-size: 1.5rem; font-weight: 800; color: var(--primary); }
.action-buttons {
    display: flex;
    flex-direction: column;
    gap: 12px;
}
.btn-order {
    padding: 16px;
    font-size: 1.1rem;
    border-radius: 12px;
    border: none;
    cursor: pointer;
    font-weight: 700;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.btn-order-primary {
    background: var(--primary);
    color: #1a1a1a;
}
.btn-order-primary:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(240,165,0,0.3);
}
.btn-order-outline {
    background: transparent;
    color: var(--primary);
    border: 1.5px solid var(--primary);
}
.btn-order-outline:hover {
    background: rgba(240,165,0,0.1);
    transform: translateY(-2px);
}
.login-cta {
    background: var(--card-bg);
    border-radius: 16px;
    padding: 30px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.05);
}
/* Modal */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.7);
    z-index: 1000;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(4px);
}
.modal-overlay.show { display: flex; }
.modal-box {
    background: var(--card-bg);
    border-radius: 20px;
    padding: 40px;
    max-width: 440px;
    width: 90%;
    border: 1px solid rgba(255,255,255,0.1);
    animation: modalIn 0.3s ease;
}
@keyframes modalIn {
    from { transform: scale(0.8); opacity: 0; }
    to   { transform: scale(1); opacity: 1; }
}
.modal-icon { font-size: 50px; margin-bottom: 10px; }
.modal-title { font-size: 1.4rem; font-weight: 700; margin-bottom: 5px; }
.modal-desc { color: var(--text-muted); font-size: 0.95rem; margin-bottom: 25px; }
.modal-detail-row {
    display: flex;
    justify-content: space-between;
    padding: 10px 0;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    font-size: 0.95rem;
}
.modal-detail-row:last-of-type { border-bottom: none; }
.modal-detail-row span:first-child { color: var(--text-muted); }
.modal-detail-row span:last-child { font-weight: 600; }
.modal-total {
    background: rgba(240,165,0,0.1);
    border-radius: 10px;
    padding: 14px 16px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 15px 0 25px;
}
.modal-total span:first-child { font-weight: 700; }
.modal-total span:last-child { font-size: 1.4rem; font-weight: 800; color: var(--primary); }
.modal-buttons { display: flex; gap: 12px; }
.modal-buttons button { flex: 1; }
.tag-available {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
    padding: 5px 14px;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
}
@media (max-width: 768px) {
    .product-hero { grid-template-columns: 1fr; gap: 24px; }
}
</style>

<div style="max-width: 1100px; margin: 0 auto; padding: 30px 0 60px;">

    {{-- Breadcrumb --}}
    <div style="margin-bottom: 24px; font-size: 0.9rem; color: var(--text-muted);">
        <a href="/" style="color: var(--text-muted);">Home</a>
        <span style="margin: 0 8px;">›</span>
        <a href="/produk" style="color: var(--text-muted);">Menu</a>
        <span style="margin: 0 8px;">›</span>
        <span style="color: var(--text-light);">{{ $product->nama_produk }}</span>
    </div>

    <div class="product-hero">
        {{-- Gambar Produk --}}
        <div class="product-image-wrap">
            @if($product->gambar)
                <img src="{{ Storage::url($product->gambar) }}" alt="{{ $product->nama_produk }}">
            @else
                <div class="product-image-placeholder">
                    🍽️
                    <p style="font-size: 1rem; margin-top: 10px;">Foto Belum Tersedia</p>
                </div>
            @endif
            <div class="badge-status">✦ Tersedia</div>
        </div>

        {{-- Info Produk --}}
        <div class="product-info">
            <div>
                <span class="tag-available">✓ Stok Tersedia</span>
                <h1 class="product-name" style="margin-top: 14px;">{{ $product->nama_produk }}</h1>
            </div>

            <div class="product-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>

            <div class="product-desc">
                <p style="color: var(--primary); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Deskripsi</p>
                {{ $product->deskripsi }}
            </div>

            @auth
                @if(auth()->user()->role === 'customer')
                    {{-- Qty Control --}}
                    <div>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 10px; font-weight: 600;">Jumlah Pesanan</p>
                        <div class="qty-control">
                            <button class="qty-btn" onclick="changeQty(-1)">−</button>
                            <input type="number" id="qty" class="qty-input" value="1" min="1" max="99" readonly>
                            <button class="qty-btn" onclick="changeQty(1)">+</button>
                        </div>
                    </div>

                    {{-- Subtotal --}}
                    <div class="subtotal-box">
                        <div>
                            <div class="subtotal-label">Total Pembayaran</div>
                            <div class="subtotal-value" id="subtotal">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                        </div>
                        <div style="font-size: 2rem;">🧾</div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class="action-buttons">
                        <form method="POST" action="{{ route('keranjang.tambah', $product->id) }}">
                            @csrf
                            <input type="hidden" name="qty" id="formQtyHidden" value="1">
                            <button type="submit" class="btn-order btn-order-primary" style="width:100%;" onclick="syncQty()">
                                🛒 Tambah ke Keranjang
                            </button>
                        </form>
                        <a href="{{ route('keranjang') }}" class="btn-order btn-order-outline" style="text-align:center; text-decoration:none;">
                            📋 Lihat Keranjang
                        </a>
                        <form method="POST" action="/favorit/{{ $product->id }}">
                            @csrf
                            <button type="submit" class="btn-order" style="width:100%; background:transparent; color:var(--text-muted); border: 1px solid rgba(255,255,255,0.1); border-radius:12px; cursor:pointer; padding:12px; font-size:0.95rem;">
                                ♡ Tambahkan ke Favorit
                            </button>
                        </form>
                    </div>

                    {{-- Poin info --}}
                    <div style="display: flex; align-items: center; gap: 8px; color: var(--text-muted); font-size: 0.9rem;">
                        <span style="font-size: 1.2rem;">⭐</span>
                        <span>Dapatkan <strong style="color: var(--primary);">+10 poin</strong> dari pesanan ini</span>
                    </div>

                @endif
            @else
                {{-- Belum login --}}
                <div class="login-cta">
                    <div style="font-size: 48px; margin-bottom: 12px;">🔐</div>
                    <h3 style="margin-bottom: 8px;">Silakan Login Terlebih Dahulu</h3>
                    <p style="color: var(--text-muted); margin-bottom: 20px; font-size: 0.95rem;">Anda perlu login untuk memesan produk ini</p>
                    <a href="/login" class="btn-order btn-order-primary" style="display: inline-flex; text-decoration: none; padding: 14px 30px; border-radius: 12px; font-size: 1rem;">
                        Login Sekarang
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>

{{-- Modal Konfirmasi --}}
@auth
@if(auth()->user()->role === 'customer')
<div class="modal-overlay" id="confirmModal">
    <div class="modal-box">
        <div style="text-align: center;">
            <div class="modal-icon">🛒</div>
            <div class="modal-title">Konfirmasi Pesanan</div>
            <div class="modal-desc">Pastikan detail pesanan Anda sudah benar sebelum melanjutkan</div>
        </div>
        <div>
            <div class="modal-detail-row">
                <span>Menu</span>
                <span>{{ $product->nama_produk }}</span>
            </div>
            <div class="modal-detail-row">
                <span>Harga Satuan</span>
                <span>Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
            </div>
            <div class="modal-detail-row">
                <span>Jumlah</span>
                <span id="modalQty">1 porsi</span>
            </div>
            <div class="modal-detail-row">
                <span>Pelanggan</span>
                <span>{{ auth()->user()->name }}</span>
            </div>
        </div>
        <div class="modal-total">
            <span>Total Bayar</span>
            <span id="modalTotal">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>
        </div>
        <div class="modal-buttons">
            <button onclick="closeModal()" class="btn-order btn-order-outline" style="cursor: pointer; border-radius: 12px;">Batal</button>
            <form method="POST" action="/pesan/{{ $product->id }}" style="flex: 1;">
                @csrf
                <input type="hidden" name="qty" id="formQty" value="1">
                <button type="submit" class="btn-order btn-order-primary" style="width: 100%; border-radius: 12px; cursor: pointer;">
                    ✓ Ya, Pesan!
                </button>
            </form>
        </div>
    </div>
</div>
@endif
@endauth

<script>
    const harga = {{ $product->harga }};

    function formatRupiah(angka) {
        return 'Rp ' + angka.toLocaleString('id-ID');
    }

    function changeQty(delta) {
        const input = document.getElementById('qty');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        if (val > 99) val = 99;
        input.value = val;
        document.getElementById('subtotal').textContent = formatRupiah(harga * val);
    }

    function syncQty() {
        const qty = document.getElementById('qty').value;
        document.getElementById('formQtyHidden').value = qty;
    }
</script>
@endsection
