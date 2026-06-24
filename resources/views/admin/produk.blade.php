@extends('layouts.admin')

@section('content')
<div style="display:flex; justify-content:space-between; align-items:center;" class="mb-2">
    <h1>Kelola Produk</h1>
    <button class="btn btn-primary" onclick="document.getElementById('form-tambah').style.display='block'">+ Tambah Produk</button>
</div>

@if(session('success'))
<div style="background: #4ade80; color: #000; padding: 10px; border-radius: 5px; margin-bottom: 15px;">
    {{ session('success') }}
</div>
@endif

<div id="form-tambah" class="card mb-2" style="display: none;">
    <h3>Tambah Menu Baru</h3>
    <form action="{{ route('admin.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Foto Menu</label>
            <input type="file" name="gambar" accept="image/*" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;">
        </div>
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Nama Produk</label>
            <input type="text" name="nama_produk" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;">
        </div>
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Deskripsi</label>
            <textarea name="deskripsi" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;" rows="3"></textarea>
        </div>
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Harga (Rp)</label>
            <input type="number" name="harga" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;">
        </div>
        <div style="margin-top: 15px;">
            <button type="submit" class="btn btn-primary">Simpan Produk</button>
            <button type="button" class="btn" style="background: rgba(255,255,255,0.1); color: white;" onclick="document.getElementById('form-tambah').style.display='none'">Batal</button>
        </div>
    </form>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Foto</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($product->gambar)
                        <img src="{{ Storage::url($product->gambar) }}" alt="Foto" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                    @else
                        <div style="width: 50px; height: 50px; background: rgba(255,255,255,0.1); border-radius: 4px; display:flex; align-items:center; justify-content:center; font-size:10px;">No Image</div>
                    @endif
                </td>
                <td>{{ $product->nama_produk }}</td>
                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                <td>
                    <button class="btn" style="background:rgba(255,255,255,0.1); color:white;" onclick="editProduk({{ $product->id }}, '{{ addslashes($product->nama_produk) }}', '{{ addslashes($product->deskripsi) }}', {{ $product->harga }})">Edit</button>
                    <form action="{{ route('admin.produk.destroy', $product->id) }}" method="POST" style="display:inline;" onsubmit="return confirm('Yakin ingin menghapus menu ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="form-edit" class="card mb-2" style="display: none; margin-top: 15px;">
    <h3>Edit Menu</h3>
    <form id="edit-form" action="" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Foto Menu Baru (Opsional)</label>
            <input type="file" name="gambar" accept="image/*" style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;">
            <small style="color:var(--text-muted);">Biarkan kosong jika tidak ingin mengubah foto</small>
        </div>
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Nama Menu</label>
            <input type="text" id="edit-nama" name="nama_produk" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;">
        </div>
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Deskripsi</label>
            <textarea id="edit-deskripsi" name="deskripsi" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;" rows="3"></textarea>
        </div>
        <div style="margin-bottom: 10px;">
            <label style="display:block; margin-bottom:5px;">Harga (Rp)</label>
            <input type="number" id="edit-harga" name="harga" required style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #ccc; background: rgba(255,255,255,0.1); color: white;">
        </div>
        <div style="margin-top: 15px;">
            <button type="submit" class="btn btn-primary">Update Menu</button>
            <button type="button" class="btn" style="background: rgba(255,255,255,0.1); color: white;" onclick="document.getElementById('form-edit').style.display='none'">Batal</button>
        </div>
    </form>
</div>

<script>
function editProduk(id, nama, deskripsi, harga) {
    document.getElementById('form-edit').style.display = 'block';
    document.getElementById('form-tambah').style.display = 'none'; // sembunyikan form tambah
    
    document.getElementById('edit-nama').value = nama;
    document.getElementById('edit-deskripsi').value = deskripsi;
    document.getElementById('edit-harga').value = harga;
    
    document.getElementById('edit-form').action = '/admin/produk/' + id;
    
    document.getElementById('form-edit').scrollIntoView({ behavior: 'smooth' });
}
</script>
@endsection
