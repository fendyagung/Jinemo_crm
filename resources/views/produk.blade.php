@extends('layouts.app')

@section('content')
<style>
/* Page Header */
.page-header {
    background: linear-gradient(135deg, rgba(20,20,20,0.8), rgba(10,10,10,0.9)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
    padding: 60px 20px;
    margin: -20px -20px 40px -20px;
    border-radius: 0 0 20px 20px;
    text-align: center;
    border-bottom: 1px solid rgba(240,165,0,0.2);
}
.page-title {
    font-size: 2.5rem;
    font-weight: 900;
    color: #fff;
    margin-bottom: 10px;
}
.page-subtitle {
    font-size: 1.1rem;
    color: rgba(255,255,255,0.8);
    max-width: 600px;
    margin: 0 auto;
}

/* Toolbar & Filters */
.toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    background: var(--card-bg);
    padding: 15px 20px;
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.05);
    flex-wrap: wrap;
    gap: 15px;
}
.search-box {
    display: flex;
    align-items: center;
    background: rgba(255,255,255,0.04);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 50px;
    padding: 8px 16px;
    flex: 1;
    max-width: 400px;
}
.search-box input {
    background: transparent;
    border: none;
    color: var(--text-light);
    outline: none;
    width: 100%;
    margin-left: 10px;
    font-family: inherit;
}
.category-chips {
    display: flex;
    gap: 10px;
    overflow-x: auto;
    padding-bottom: 5px;
}
.chip {
    padding: 8px 20px;
    background: rgba(255,255,255,0.05);
    border: 1px solid rgba(255,255,255,0.1);
    border-radius: 50px;
    color: var(--text-muted);
    cursor: pointer;
    white-space: nowrap;
    transition: 0.3s;
    font-size: 0.9rem;
    font-weight: 600;
}
.chip:hover, .chip.active {
    background: rgba(240,165,0,0.15);
    border-color: var(--primary);
    color: var(--primary);
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 25px;
}
.prod-card {
    background: var(--card-bg);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.05);
    overflow: hidden;
    transition: all 0.3s;
    display: flex;
    flex-direction: column;
}
.prod-card:hover {
    transform: translateY(-5px);
    border-color: rgba(240,165,0,0.3);
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
.prod-img {
    height: 220px;
    background-color: rgba(255,255,255,0.02);
    background-size: cover;
    background-position: center;
    position: relative;
}
.prod-body {
    padding: 20px;
    display: flex;
    flex-direction: column;
    flex: 1;
}
.prod-title {
    font-size: 1.2rem;
    font-weight: 700;
    margin-bottom: 8px;
    color: var(--text-light);
}
.prod-desc {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-bottom: 15px;
    line-height: 1.5;
    flex: 1;
}
.prod-price-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: auto;
    padding-top: 15px;
    border-top: 1px solid rgba(255,255,255,0.05);
}
.prod-price {
    font-size: 1.4rem;
    font-weight: 800;
    color: var(--primary);
}
.prod-btn {
    padding: 8px 18px;
    background: var(--primary);
    color: #1a1a1a;
    border-radius: 50px;
    font-weight: 700;
    font-size: 0.9rem;
    text-decoration: none;
    transition: 0.2s;
}
.prod-btn:hover {
    background: var(--primary-dark);
    transform: scale(1.05);
}

/* Empty state */
.empty-state {
    text-align: center;
    padding: 60px 20px;
    background: var(--card-bg);
    border-radius: 20px;
    border: 1px dashed rgba(255,255,255,0.1);
    grid-column: 1 / -1;
}
</style>

<div class="page-header">
    <h1 class="page-title">Katalog Menu Nusantara</h1>
    <p class="page-subtitle">Temukan berbagai hidangan khas Indonesia Timur yang menggugah selera, siap dinikmati kapan saja.</p>
</div>

<div class="toolbar">
    <div class="category-chips">
        <div class="chip active" onclick="filterMenu('all')">🍽️ Semua Menu</div>
        <div class="chip" onclick="filterMenu('Makanan')">🍛 Makanan Utama</div>
        <div class="chip" onclick="filterMenu('Minuman')">🍹 Minuman</div>
        <div class="chip" onclick="filterMenu('Cemilan')">🥨 Cemilan Spesial</div>
    </div>
    <div class="search-box">
        <span>🔍</span>
        <input type="text" id="searchInput" placeholder="Cari menu favorit Anda..." onkeyup="searchMenu()">
    </div>
</div>

<div class="product-grid" id="productGrid">
    @forelse($products as $p)
    <div class="prod-card menu-item" data-title="{{ strtolower($p->nama_produk) }}">
        @if($p->gambar)
            <div class="prod-img" style="background-image: url('{{ Storage::url($p->gambar) }}')"></div>
        @else
            <div class="prod-img">
                <div style="height:100%; display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.1); font-size:3rem;">🍽️</div>
            </div>
        @endif
        <div class="prod-body">
            <div class="prod-title">{{ $p->nama_produk }}</div>
            <div class="prod-desc">{{ Str::limit($p->deskripsi ?? 'Hidangan istimewa dari Jinemo dengan resep warisan otentik.', 80) }}</div>
            <div class="prod-price-row">
                <div class="prod-price">Rp {{ number_format($p->harga, 0, ',', '.') }}</div>
                <a href="/produk/{{ $p->id }}" class="prod-btn">Pesan</a>
            </div>
        </div>
    </div>
    @empty
    <div class="empty-state">
        <div style="font-size: 50px; margin-bottom: 15px;">😔</div>
        <h3 style="margin-bottom: 10px;">Menu Belum Tersedia</h3>
        <p style="color: var(--text-muted);">Mohon maaf, saat ini belum ada menu yang ditambahkan.</p>
    </div>
    @endforelse
</div>

<script>
// Simple JS for UI filtering/searching without reloading
function filterMenu(category) {
    // UI update for chips
    document.querySelectorAll('.chip').forEach(c => c.classList.remove('active'));
    event.target.classList.add('active');
    
    // Note: Category filtering would require database tags, but this gives a nice UI feel
    // For this demo, we'll just show all since we don't have a category column yet
    if(category !== 'all') {
        const input = document.getElementById('searchInput');
        input.value = category; // Auto search by category keyword
        searchMenu();
    } else {
        document.getElementById('searchInput').value = '';
        searchMenu();
    }
}

function searchMenu() {
    const input = document.getElementById('searchInput').value.toLowerCase();
    const items = document.querySelectorAll('.menu-item');
    let hasVisible = false;

    items.forEach(item => {
        const title = item.getAttribute('data-title');
        if (title.includes(input)) {
            item.style.display = 'flex';
            hasVisible = true;
        } else {
            item.style.display = 'none';
        }
    });
}
</script>
@endsection
