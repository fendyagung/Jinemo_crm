@extends('layouts.app')

@section('content')
<style>
.cart-layout {
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 30px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 30px 0 60px;
    align-items: start;
}
.cart-header {
    display: flex;
    align-items: center;
    gap: 14px;
    margin-bottom: 24px;
}
.cart-title {
    font-size: 1.8rem;
    font-weight: 700;
}
.cart-badge {
    background: var(--primary);
    color: #1a1a1a;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 4px 12px;
    border-radius: 50px;
}
.cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    padding: 20px 0;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.cart-item:last-child { border-bottom: none; }
.cart-item-img {
    width: 90px;
    height: 90px;
    border-radius: 12px;
    object-fit: cover;
    background: rgba(255,255,255,0.05);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
}
.cart-item-info { flex: 1; }
.cart-item-name {
    font-weight: 700;
    font-size: 1.05rem;
    margin-bottom: 4px;
}
.cart-item-price {
    color: var(--primary);
    font-weight: 600;
    font-size: 0.95rem;
    margin-bottom: 10px;
}
.cart-item-actions {
    display: flex;
    align-items: center;
    gap: 16px;
    font-size: 0.85rem;
    color: var(--text-muted);
}
.cart-item-actions a {
    color: var(--text-muted);
    cursor: pointer;
    transition: 0.2s;
}
.cart-item-actions a:hover { color: #ef4444; }
.qty-wrap {
    display: flex;
    align-items: center;
    gap: 0;
    background: rgba(255,255,255,0.06);
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid rgba(255,255,255,0.1);
}
.qty-btn {
    width: 36px;
    height: 36px;
    background: transparent;
    border: none;
    color: var(--text-light);
    font-size: 1.2rem;
    cursor: pointer;
    transition: 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}
.qty-btn:hover { background: rgba(240,165,0,0.15); color: var(--primary); }
.qty-num {
    width: 44px;
    text-align: center;
    background: transparent;
    border: none;
    border-left: 1px solid rgba(255,255,255,0.1);
    border-right: 1px solid rgba(255,255,255,0.1);
    color: var(--text-light);
    font-size: 1rem;
    font-weight: 700;
    padding: 0;
    height: 36px;
}
.qty-num:focus { outline: none; }
.item-subtotal {
    font-size: 1rem;
    font-weight: 700;
    color: var(--text-light);
    min-width: 100px;
    text-align: right;
}

/* Summary Panel */
.summary-panel {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.07);
    overflow: hidden;
    position: sticky;
    top: 90px;
}
.summary-panel-header {
    padding: 20px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    font-weight: 700;
    font-size: 1rem;
    color: var(--text-muted);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.85rem;
}
.summary-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 24px;
    border-bottom: 1px solid rgba(255,255,255,0.05);
    font-size: 0.95rem;
}
.summary-row span:first-child { color: var(--text-muted); }
.summary-row.total {
    padding: 18px 24px;
    font-size: 1.05rem;
    font-weight: 700;
    border-bottom: none;
}
.summary-row.total span:last-child {
    color: var(--primary);
    font-size: 1.3rem;
}
.discount-wrap {
    padding: 0 24px 16px;
    display: flex;
    gap: 10px;
}
.discount-input {
    flex: 1;
    padding: 10px 14px;
    border-radius: 10px;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    color: var(--text-light);
    font-size: 0.9rem;
}
.discount-input:focus { outline: none; border-color: var(--primary); }
.discount-input::placeholder { color: var(--text-muted); }
.btn-terapkan {
    padding: 10px 16px;
    background: rgba(240,165,0,0.1);
    color: var(--primary);
    border: 1px solid rgba(240,165,0,0.3);
    border-radius: 10px;
    cursor: pointer;
    font-weight: 600;
    font-size: 0.9rem;
    white-space: nowrap;
    transition: 0.2s;
}
.btn-terapkan:hover { background: rgba(240,165,0,0.2); }
.btn-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    width: calc(100% - 48px);
    margin: 0 24px 16px;
    padding: 15px;
    background: var(--primary);
    color: #1a1a1a;
    border: none;
    border-radius: 12px;
    font-size: 1.05rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    text-decoration: none;
}
.btn-checkout:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(240,165,0,0.3);
    color: #1a1a1a;
}
.btn-lanjut {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 12px 24px;
    color: var(--text-muted);
    font-size: 0.9rem;
    text-decoration: none;
    transition: 0.2s;
    border-top: 1px solid rgba(255,255,255,0.05);
}
.btn-lanjut:hover { color: var(--primary); }
.empty-cart {
    text-align: center;
    padding: 80px 20px;
    color: var(--text-muted);
}
.empty-cart-icon { font-size: 80px; margin-bottom: 20px; }

@media (max-width: 768px) {
    .cart-layout { grid-template-columns: 1fr; }
    .summary-panel { position: static; }
}
</style>

<div class="cart-layout">
    {{-- Kiri: Daftar Item --}}
    <div>
        {{-- Breadcrumb --}}
        <div style="margin-bottom: 20px; font-size: 0.9rem; color: var(--text-muted);">
            <a href="/" style="color:var(--text-muted);">Beranda</a>
            <span style="margin: 0 8px;">›</span>
            <a href="/produk" style="color:var(--text-muted);">Menu</a>
            <span style="margin: 0 8px;">›</span>
            <span style="color:var(--text-light);">Keranjang</span>
        </div>

        <div class="cart-header">
            <h1 class="cart-title">Ringkasan Pesanan</h1>
            @if(count($cart) > 0)
                <span class="cart-badge">{{ count($cart) }} item</span>
            @endif
        </div>

        @if(session('success'))
            <div style="background: rgba(34,197,94,0.1); border: 1px solid rgba(34,197,94,0.3); color: #22c55e; padding: 12px 16px; border-radius: 10px; margin-bottom: 20px; font-size: 0.9rem;">
                ✓ {{ session('success') }}
            </div>
        @endif

        @if(count($cart) === 0)
            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <h3 style="margin-bottom: 10px; color: var(--text-light);">Keranjang Anda Kosong</h3>
                <p style="margin-bottom: 24px;">Belum ada produk yang ditambahkan ke keranjang.</p>
                <a href="/produk" class="btn btn-primary">Lihat Menu</a>
            </div>
        @else
            <div class="card" style="padding: 0 24px;">
                @foreach($cart as $id => $item)
                <div class="cart-item">
                    {{-- Gambar --}}
                    @if($item['gambar'])
                        <img class="cart-item-img" src="{{ Storage::url($item['gambar']) }}" alt="{{ $item['nama_produk'] }}">
                    @else
                        <div class="cart-item-img">🍽️</div>
                    @endif

                    {{-- Info --}}
                    <div class="cart-item-info">
                        <div class="cart-item-name">{{ $item['nama_produk'] }}</div>
                        <div class="cart-item-price">Rp {{ number_format($item['harga'], 0, ',', '.') }} / porsi</div>
                        <div class="cart-item-actions">
                            {{-- Hapus --}}
                            <form method="POST" action="{{ route('keranjang.hapus', $id) }}" style="display:inline;">
                                @csrf
                                <button type="submit" style="background:none; border:none; color:var(--text-muted); cursor:pointer; font-size: 0.85rem; transition:0.2s;"
                                    onmouseover="this.style.color='#ef4444'" onmouseout="this.style.color='var(--text-muted)'">
                                    🗑 Hapus
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Qty --}}
                    <form method="POST" action="{{ route('keranjang.update', $id) }}" id="form-qty-{{ $id }}">
                        @csrf
                        <div class="qty-wrap">
                            <button type="button" class="qty-btn" onclick="changeQty({{ $id }}, -1)">−</button>
                            <input type="number" name="qty" id="qty-{{ $id }}" class="qty-num"
                                value="{{ $item['qty'] }}" min="1" max="99"
                                onchange="document.getElementById('form-qty-{{ $id }}').submit()">
                            <button type="button" class="qty-btn" onclick="changeQty({{ $id }}, 1)">+</button>
                        </div>
                    </form>

                    {{-- Subtotal item --}}
                    <div class="item-subtotal">Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}</div>
                </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Kanan: Panel Ringkasan --}}
    <div class="summary-panel">
        <div class="summary-panel-header">Ringkasan Pembayaran</div>

        <div class="summary-row">
            <span>Pengiriman</span>
            <span style="color: #22c55e; font-weight: 600;">Gratis</span>
        </div>
        <div class="summary-row">
            <span>Subtotal ({{ count($cart) }} item)</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row total">
            <span>Total</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        {{-- Kode Diskon --}}
        <div class="discount-wrap">
            <input type="text" class="discount-input" placeholder="Kode diskon...">
            <button class="btn-terapkan">Terapkan</button>
        </div>

        {{-- Tombol Pesan Sekarang --}}
        @if(count($cart) > 0)
            <form method="POST" action="{{ route('keranjang.checkout') }}">
                @csrf
                <button type="submit" class="btn-checkout">
                    Pesan Sekarang ›
                </button>
            </form>
        @else
            <div style="padding: 0 24px 16px;">
                <span class="btn-checkout" style="opacity: 0.4; cursor: not-allowed;">Pesan Sekarang ›</span>
            </div>
        @endif

        {{-- Lanjutkan belanja --}}
        <a href="/produk" class="btn-lanjut">‹ Lanjutkan belanja</a>
    </div>
</div>

<script>
function changeQty(id, delta) {
    const input = document.getElementById('qty-' + id);
    let val = parseInt(input.value) + delta;
    if (val < 1) val = 1;
    if (val > 99) val = 99;
    input.value = val;
    document.getElementById('form-qty-' + id).submit();
}
</script>
@endsection
