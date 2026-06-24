@extends('layouts.app')

@section('content')
<style>
.testi-layout {
    display: grid;
    grid-template-columns: 1fr 420px;
    gap: 30px;
    max-width: 1100px;
    margin: 30px auto 60px;
    align-items: start;
}
/* Form */
.form-card {
    background: var(--card-bg);
    border-radius: 20px;
    border: 1px solid rgba(255,255,255,0.07);
    overflow: hidden;
}
.form-card-header {
    padding: 24px 28px;
    border-bottom: 1px solid rgba(255,255,255,0.06);
    background: linear-gradient(135deg, rgba(240,165,0,0.08), transparent);
}
.form-card-header h2 { font-size: 1.2rem; font-weight: 700; }
.form-card-header p { color: var(--text-muted); font-size: 0.88rem; margin-top: 4px; }
.form-card-body { padding: 28px; }
.form-label {
    display: block;
    font-size: 0.85rem;
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
}
.form-input:focus {
    outline: none;
    border-color: var(--primary);
    background: rgba(240,165,0,0.04);
}
.form-input::placeholder { color: rgba(255,255,255,0.3); }
.mb-20 { margin-bottom: 20px; }
/* Star Rating */
.star-rating {
    display: flex;
    gap: 8px;
    flex-direction: row-reverse;
    justify-content: flex-end;
}
.star-rating input { display: none; }
.star-rating label {
    font-size: 2rem;
    cursor: pointer;
    color: rgba(255,255,255,0.2);
    transition: color 0.15s;
}
.star-rating input:checked ~ label,
.star-rating label:hover,
.star-rating label:hover ~ label {
    color: var(--primary);
}
.btn-submit {
    width: 100%;
    padding: 14px;
    background: var(--primary);
    color: #1a1a1a;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    margin-top: 24px;
}
.btn-submit:hover {
    background: var(--primary-dark);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(240,165,0,0.3);
}
/* Ulasan */
.ulasan-panel { display: flex; flex-direction: column; gap: 16px; }
.ulasan-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 4px;
}
.ulasan-title { font-size: 1.05rem; font-weight: 700; }
.ulasan-count { background: rgba(240,165,0,0.1); color: var(--primary); font-size: 0.8rem; font-weight: 600; padding: 4px 12px; border-radius: 50px; }
.ulasan-card {
    background: var(--card-bg);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.06);
    padding: 20px;
    transition: 0.2s;
}
.ulasan-card:hover { border-color: rgba(240,165,0,0.2); }
.ulasan-top { display: flex; align-items: center; gap: 12px; margin-bottom: 12px; }
.ulasan-avatar {
    width: 42px; height: 42px; border-radius: 50%;
    background: linear-gradient(135deg, #f0a500, #cf8d00);
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; color: #1a1a1a; font-size: 1rem; flex-shrink: 0;
}
.ulasan-user-name { font-weight: 600; font-size: 0.95rem; }
.ulasan-date { color: var(--text-muted); font-size: 0.8rem; }
.ulasan-stars { color: var(--primary); font-size: 1rem; letter-spacing: 2px; }
.ulasan-text { color: rgba(255,255,255,0.75); font-size: 0.9rem; line-height: 1.7; font-style: italic; }
.ulasan-text::before { content: '"'; color: var(--primary); font-size: 1.2rem; }
.ulasan-text::after  { content: '"'; color: var(--primary); font-size: 1.2rem; }
.empty-ulasan { text-align: center; padding: 40px 20px; color: var(--text-muted); background: var(--card-bg); border-radius: 16px; }
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
    .testi-layout { grid-template-columns: 1fr; }
}
</style>

<div class="testi-layout">

    {{-- KIRI: Form Testimoni --}}
    <div>
        <div class="form-card">
            <div class="form-card-header">
                <h2>⭐ Tulis Ulasan Anda</h2>
                <p>Bagikan pengalaman Anda menikmati masakan Jinemo kepada pelanggan lainnya</p>
            </div>
            <div class="form-card-body">
                @if(session('success'))
                    <div class="alert-success">✓ {{ session('success') }}</div>
                @endif

                <form method="POST" action="/testimoni">
                    @csrf

                    {{-- Star Rating --}}
                    <div class="mb-20">
                        <label class="form-label">Beri Rating</label>
                        <div class="star-rating">
                            <input type="radio" name="rating" id="star5" value="5"><label for="star5">★</label>
                            <input type="radio" name="rating" id="star4" value="4"><label for="star4">★</label>
                            <input type="radio" name="rating" id="star3" value="3"><label for="star3">★</label>
                            <input type="radio" name="rating" id="star2" value="2"><label for="star2">★</label>
                            <input type="radio" name="rating" id="star1" value="1" checked><label for="star1">★</label>
                        </div>
                    </div>

                    {{-- Komentar --}}
                    <div class="mb-20">
                        <label class="form-label" for="komentar">Komentar / Ulasan</label>
                        <textarea name="komentar" id="komentar" class="form-input"
                            rows="5" required
                            placeholder="Ceritakan pengalaman Anda — rasa makanannya, pelayanannya, kecepatannya..."></textarea>
                    </div>

                    {{-- Info User --}}
                    <div style="background: rgba(255,255,255,0.03); border-radius: 10px; padding: 14px 16px; display:flex; align-items:center; gap:12px; border: 1px solid rgba(255,255,255,0.06);">
                        <div style="width:36px; height:36px; border-radius:50%; background: var(--primary); display:flex; align-items:center; justify-content:center; font-weight:700; color:#1a1a1a; font-size:0.9rem; flex-shrink:0;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div style="font-weight:600; font-size:0.9rem;">{{ auth()->user()->name }}</div>
                            <div style="color:var(--text-muted); font-size:0.8rem;">Ulasan akan ditampilkan dengan nama Anda</div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        ✓ Kirim Ulasan
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- KANAN: Tampilan Ulasan --}}
    <div class="ulasan-panel">
        <div class="ulasan-header">
            <div class="ulasan-title">💬 Ulasan Pelanggan</div>
            <span class="ulasan-count">{{ $testimonials->count() }} ulasan</span>
        </div>

        @if($testimonials->count() > 0)
            @foreach($testimonials as $t)
            <div class="ulasan-card">
                <div class="ulasan-top">
                    <div class="ulasan-avatar">{{ strtoupper(substr($t->user->name ?? 'A', 0, 1)) }}</div>
                    <div>
                        <div class="ulasan-user-name">{{ $t->user->name ?? 'Pelanggan' }}</div>
                        <div class="ulasan-date">{{ $t->created_at->diffForHumans() }}</div>
                    </div>
                    <div style="margin-left: auto;">
                        <div class="ulasan-stars">
                            @for($i = 1; $i <= 5; $i++)
                                {{ $i <= $t->rating ? '★' : '☆' }}
                            @endfor
                        </div>
                    </div>
                </div>
                <div class="ulasan-text">{{ $t->komentar }}</div>
            </div>
            @endforeach
        @else
            <div class="empty-ulasan">
                <div style="font-size: 48px; margin-bottom: 12px;">💬</div>
                <p style="font-weight:600; margin-bottom:6px;">Belum Ada Ulasan</p>
                <p style="font-size: 0.85rem;">Jadilah yang pertama memberikan ulasan!</p>
            </div>
        @endif
    </div>
</div>
@endsection
