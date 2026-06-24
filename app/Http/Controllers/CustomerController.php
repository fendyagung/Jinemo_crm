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
        return view('customer.profil', compact('favorites'));
    }
    public function riwayat() {
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('customer.riwayat', compact('orders'));
    }
    public function testimoni() {
        return view('customer.testimoni');
    }
    public function storeTestimoni(Request $request) {
        Testimonial::create([
            'user_id' => Auth::id(),
            'rating' => $request->rating,
            'komentar' => $request->komentar
        ]);
        return back()->with('success', 'Testimoni berhasil dikirim. Terima kasih!');
    }
    public function pengaduan() {
        return view('customer.pengaduan');
    }
    public function storePengaduan(Request $request) {
        Complaint::create([
            'user_id' => Auth::id(),
            'subjek' => $request->subjek,
            'isi_keluhan' => $request->isi_keluhan,
            'status' => 'Baru'
        ]);
        return back()->with('success', 'Pengaduan berhasil dikirim. Kami akan segera merespon.');
    }
    public function pesan($id) {
        // Dummy order process
        $product = Product::findOrFail($id);
        Order::create([
            'user_id' => Auth::id(),
            'total_harga' => $product->harga,
            'status' => 'Pending'
        ]);
        // Add loyalty point
        $user = Auth::user();
        $user->point += 10;
        $user->save();
        return redirect('/riwayat');
    }
    public function favorit($id) {
        DB::table('favorites')->insertOrIgnore([
            'user_id' => Auth::id(),
            'product_id' => $id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
        return redirect('/profil');
    }
}
