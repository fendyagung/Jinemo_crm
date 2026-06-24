@extends('layouts.app')

@section('content')
<style>
.about-hero {
    position: relative;
    padding: 80px 20px;
    margin: -20px -20px 40px -20px;
    background: linear-gradient(135deg, rgba(20,20,20,0.95), rgba(10,10,10,0.98)), url('https://images.unsplash.com/photo-1547592180-85f173990554?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=80') center/cover;
    border-radius: 0 0 30px 30px;
    text-align: center;
    border-bottom: 2px solid rgba(240,165,0,0.2);
}
.about-title { font-size: 3rem; font-weight: 900; color: #fff; margin-bottom: 10px; }
.about-title span { color: var(--primary); }
.about-sub { font-size: 1.1rem; color: rgba(255,255,255,0.8); max-width: 600px; margin: 0 auto; line-height: 1.6; }

.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center; margin-bottom: 60px; }
.about-img {
    width: 100%; height: 400px; border-radius: 20px; object-fit: cover;
    border: 1px solid rgba(255,255,255,0.1);
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
}
.about-text h2 { font-size: 2rem; font-weight: 800; margin-bottom: 20px; color: var(--primary); }
.about-text p { color: var(--text-muted); line-height: 1.8; margin-bottom: 16px; font-size: 1.05rem; }

.visi-misi { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 60px; }
.vm-card {
    background: var(--card-bg); border-radius: 20px; padding: 30px;
    border: 1px solid rgba(255,255,255,0.05); text-align: center;
    transition: 0.3s;
}
.vm-card:hover { transform: translateY(-5px); border-color: rgba(240,165,0,0.3); }
.vm-icon { font-size: 40px; margin-bottom: 15px; }
.vm-title { font-size: 1.4rem; font-weight: 800; margin-bottom: 15px; color: var(--text-light); }
.vm-desc { color: var(--text-muted); line-height: 1.6; }

@media (max-width: 768px) {
    .about-grid { grid-template-columns: 1fr; }
    .visi-misi { grid-template-columns: 1fr; }
    .about-hero { padding: 50px 20px; }
    .about-title { font-size: 2.2rem; }
}
</style>

<div class="about-hero">
    <h1 class="about-title">Tentang <span>Jinemo</span></h1>
    <p class="about-sub">Menghadirkan Cita Rasa Asli Indonesia Timur Langsung ke Meja Anda</p>
</div>

<div class="about-grid">
    <div>
        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Masakan Nusantara" class="about-img">
    </div>
    <div class="about-text">
        <h2>Sejarah Kami</h2>
        <p>Berdiri sejak tahun 2026, <strong>Jinemo</strong> lahir dari kecintaan kami terhadap kekayaan rempah dan budaya kuliner Nusantara, khususnya dari wilayah Indonesia Timur. Kami menyadari bahwa menemukan hidangan otentik dengan resep leluhur di tengah kota bukanlah hal yang mudah.</p>
        <p>Oleh karena itu, Jinemo hadir sebagai solusi jembatan kuliner yang menghubungkan para penikmat makanan dengan cita rasa asli kampung halaman. Setiap hidangan yang kami sajikan dimasak menggunakan bahan-bahan segar berkualitas yang dipilih langsung oleh koki ahli kami.</p>
        <p>Dengan sistem <em>E-CRM (Customer Relationship Management)</em>, kami tidak hanya menyajikan makanan, tetapi juga berdedikasi untuk memberikan layanan dan pengalaman pelanggan yang tak terlupakan melalui sistem poin loyalitas dan kemudahan pemesanan.</p>
    </div>
</div>

<div class="visi-misi">
    <div class="vm-card">
        <div class="vm-icon">🎯</div>
        <div class="vm-title">Visi</div>
        <div class="vm-desc">Menjadi platform kuliner nusantara terdepan yang menjaga kelestarian resep tradisional Indonesia Timur dan menghadirkannya kepada masyarakat luas dengan standar kualitas tinggi.</div>
    </div>
    <div class="vm-card">
        <div class="vm-icon">🚀</div>
        <div class="vm-title">Misi</div>
        <div class="vm-desc">
            1. Menyajikan hidangan otentik dengan bahan premium berkualitas.<br>
            2. Memberikan pengalaman pelanggan terbaik melalui platform e-CRM.<br>
            3. Memberdayakan petani rempah lokal untuk pasokan bahan baku.
        </div>
    </div>
</div>

@endsection
