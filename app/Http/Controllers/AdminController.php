<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Testimonial;
use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller {
    public function dashboard() {
        $total_pelanggan  = User::where('role', 'customer')->count();
        $total_produk     = Product::count();
        $total_pesanan    = Order::count();
        $total_pengaduan  = Complaint::count();
        $recent_orders    = Order::with('user')->latest()->limit(5)->get();
        $recent_customers = User::where('role', 'customer')->latest()->limit(5)->get();
        return view('admin.dashboard', compact(
            'total_pelanggan', 'total_produk', 'total_pesanan', 'total_pengaduan',
            'recent_orders', 'recent_customers'
        ));
    }
    public function produk() {
        $products = Product::all();
        return view('admin.produk', compact('products'));
    }

    public function storeProduk(Request $request) {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        Product::create($data);

        return redirect('/admin/produk')->with('success', 'Produk berhasil ditambahkan.');
    }

    public function updateProduk(Request $request, $id) {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $product = Product::findOrFail($id);
        
        $data = [
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
        ];

        if ($request->hasFile('gambar')) {
            if ($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('produk', 'public');
        }

        $product->update($data);

        return redirect('/admin/produk')->with('success', 'Menu / Produk berhasil diperbarui.');
    }

    public function destroyProduk($id) {
        $product = Product::findOrFail($id);
        if ($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        $product->delete();

        return redirect('/admin/produk')->with('success', 'Menu / Produk berhasil dihapus.');
    }

    public function pelanggan() {
        $customers = User::where('role', 'customer')->get();
        return view('admin.pelanggan', compact('customers'));
    }
    public function pesanan() {
        $orders = Order::with('user')->get();
        return view('admin.pesanan', compact('orders'));
    }
    public function testimoni() {
        $testimonials = Testimonial::with('user')->latest()->get();
        return view('admin.testimoni', compact('testimonials'));
    }
    public function pengaduan() {
        $complaints = Complaint::with('user')->get();
        return view('admin.pengaduan', compact('complaints'));
    }
}
