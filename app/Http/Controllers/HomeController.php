<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller {
    public function index() {
        $products = Product::take(3)->get();
        return view('welcome', compact('products'));
    }
    public function produk() {
        $products = Product::all();
        return view('produk', compact('products'));
    }
    public function detail($id) {
        $product = Product::findOrFail($id);
        return view('detail', compact('product'));
    }
}
