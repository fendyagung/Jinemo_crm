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

    public function profil() {
        $stats = [
            'pelanggan' => User::where('role', 'customer')->count(),
            'produk'    => Product::count(),
            'pesanan'   => Order::count(),
            'pengaduan' => Complaint::count(),
        ];
        return view('admin.profil', compact('stats'));
    }

    public function updateProfil(Request $request) {
        $request->validate([
            'name'     => 'required|string|max:255',
            'password' => 'nullable|min:8|confirmed',
            'foto'     => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();
        $user->name = $request->name;

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('foto_profil', 'public');
        }

        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();
        return redirect('/admin/profil')->with('success', 'Profil admin berhasil diperbarui!');
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
        $customers = User::where('role', 'customer')->latest()->get();
        return view('admin.pelanggan', compact('customers'));
    }
    public function pesanan() {
        $orders = Order::with('user')->latest()->get();
        return view('admin.pesanan', compact('orders'));
    }
    public function updateStatusPesanan(Request $request, $id) {
        $order = Order::with('user')->findOrFail($id);
        $old_status = $order->status;
        $new_status = $request->status;

        if ($old_status != 'Selesai' && $new_status == 'Selesai') {
            // Tambah 10 poin jika status berubah menjadi Selesai
            if ($order->user) {
                $order->user->point += 10;
                $order->user->save();
            }
        } elseif ($old_status == 'Selesai' && $new_status != 'Selesai') {
            // Kurangi 10 poin jika status berubah dari Selesai ke status lain
            if ($order->user) {
                $order->user->point = max(0, $order->user->point - 10);
                $order->user->save();
            }
        }

        $order->status = $new_status;
        $order->save();
        return redirect('/admin/pesanan')->with('success', 'Status pesanan #' . str_pad($id, 5, '0', STR_PAD_LEFT) . ' berhasil diperbarui.');
    }
    public function laporan() {
        $total_pendapatan   = Order::where('status', 'Selesai')->sum('total_harga');
        $total_pesanan      = Order::count();
        $pesanan_selesai    = Order::where('status', 'Selesai')->count();
        $pesanan_pending    = Order::where('status', 'Pending')->count();
        $pesanan_diproses   = Order::where('status', 'Diproses')->count();
        $total_pelanggan    = User::where('role', 'customer')->count();
        $total_produk       = Product::count();
        $total_testimoni    = Testimonial::count();
        $total_pengaduan    = Complaint::count();
        $rata_rating        = Testimonial::avg('rating');
        // Pesanan per bulan (6 bulan terakhir)
        $pesanan_bulanan = Order::selectRaw('MONTH(created_at) as bulan, COUNT(*) as total, SUM(total_harga) as pendapatan')
            ->whereYear('created_at', date('Y'))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        return view('admin.laporan', compact(
            'total_pendapatan', 'total_pesanan', 'pesanan_selesai', 'pesanan_pending',
            'pesanan_diproses', 'total_pelanggan', 'total_produk', 'total_testimoni',
            'total_pengaduan', 'rata_rating', 'pesanan_bulanan'
        ));
    }
    public function testimoni() {
        $testimonials = Testimonial::with('user')->latest()->get();
        return view('admin.testimoni', compact('testimonials'));
    }
    public function pengaduan() {
        $complaints = Complaint::with('user')->latest()->get();
        return view('admin.pengaduan', compact('complaints'));
    }
}
