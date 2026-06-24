<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Testimonial;
use App\Models\Complaint;
use App\Models\Product;

class CustomerController extends Controller {

    public function profil() {
        $favorites = DB::table('favorites')
            ->join('products', 'favorites.product_id', '=', 'products.id')
            ->where('favorites.user_id', Auth::id())
            ->select('favorites.*', 'products.nama_produk')
            ->get();
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('customer.profil', compact('favorites', 'orders'));
    }

    public function updateProfil(Request $request) {
        $request->validate([
            'name'                  => 'required|string|max:255',
            'password'              => 'nullable|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->name = $request->name;
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }
        $user->save();

        return redirect('/profil')->with('success', 'Profil berhasil diperbarui!');
    }

    public function riwayat() {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('customer.riwayat', compact('orders'));
    }

    public function testimoni() {
        $testimonials = Testimonial::with('user')->latest()->get();
        return view('customer.testimoni', compact('testimonials'));
    }

    public function storeTestimoni(Request $request) {
        Testimonial::create([
            'user_id' => Auth::id(),
            'rating'  => $request->rating,
            'komentar'=> $request->komentar
        ]);
        return back()->with('success', 'Testimoni berhasil dikirim. Terima kasih!');
    }

    public function pengaduan() {
        return view('customer.pengaduan');
    }

    public function storePengaduan(Request $request) {
        Complaint::create([
            'user_id'    => Auth::id(),
            'subjek'     => $request->subjek,
            'isi_keluhan'=> $request->isi_keluhan,
            'status'     => 'Baru'
        ]);
        return back()->with('success', 'Pengaduan berhasil dikirim. Kami akan segera merespon.');
    }

    public function favorit($id) {
        DB::table('favorites')->insertOrIgnore([
            'user_id'    => Auth::id(),
            'product_id' => $id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return redirect('/profil')->with('success', 'Produk ditambahkan ke favorit!');
    }

    // =====================
    // KERANJANG (Cart)
    // =====================

    public function keranjang() {
        $cart  = session()->get('cart', []);
        $total = collect($cart)->sum(fn($i) => $i['harga'] * $i['qty']);
        return view('keranjang', compact('cart', 'total'));
    }

    public function tambahKeranjang(Request $request, $id) {
        $product = Product::findOrFail($id);
        $qty     = max(1, (int) $request->input('qty', 1));
        $cart    = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['qty'] += $qty;
        } else {
            $cart[$id] = [
                'nama_produk' => $product->nama_produk,
                'harga'       => $product->harga,
                'gambar'      => $product->gambar,
                'qty'         => $qty,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('keranjang')->with('success', $product->nama_produk . ' ditambahkan ke keranjang!');
    }

    public function updateKeranjang(Request $request, $id) {
        $cart = session()->get('cart', []);
        $qty  = max(1, (int) $request->input('qty', 1));

        if (isset($cart[$id])) {
            $cart[$id]['qty'] = $qty;
            session()->put('cart', $cart);
        }

        return redirect()->route('keranjang');
    }

    public function hapusKeranjang($id) {
        $cart = session()->get('cart', []);
        unset($cart[$id]);
        session()->put('cart', $cart);
        return redirect()->route('keranjang')->with('success', 'Item dihapus dari keranjang.');
    }

    public function checkout(Request $request) {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('keranjang')->with('error', 'Keranjang kosong!');
        }

        $total = collect($cart)->sum(fn($i) => $i['harga'] * $i['qty']);

        Order::create([
            'user_id'     => Auth::id(),
            'total_harga' => $total,
            'status'      => 'Pending'
        ]);

        // Tambah poin
        $user = Auth::user();
        $user->point += 10;
        $user->save();

        session()->forget('cart');

        return redirect('/riwayat')->with('success', 'Pesanan berhasil dibuat! +10 poin ditambahkan ke akun Anda.');
    }
}
