<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\Testimonial;
use App\Models\Complaint;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Admin Jinemo',
            'email' => 'admin@jinemo.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'point' => 0
        ]);

        // Create Customer
        $customer = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password123'),
            'role' => 'customer',
            'point' => 50
        ]);

        // Create Products
        $p1 = Product::create([
            'nama_produk' => 'Ikan Kuah Kuning',
            'deskripsi' => 'Ikan segar yang dimasak dengan kuah kuning khas Maluku yang kaya akan rempah.',
            'harga' => 45000
        ]);
        $p2 = Product::create([
            'nama_produk' => 'Papeda',
            'deskripsi' => 'Makanan pokok khas Indonesia Timur yang terbuat dari sagu, sangat cocok disantap dengan ikan kuah kuning.',
            'harga' => 20000
        ]);
        $p3 = Product::create([
            'nama_produk' => 'Ayam Taliwang',
            'deskripsi' => 'Ayam bakar pedas khas Lombok dengan bumbu pelengkap pelecing kangkung.',
            'harga' => 55000
        ]);

        // Create Order
        Order::create([
            'user_id' => $customer->id,
            'total_harga' => 65000,
            'status' => 'Selesai'
        ]);

        // Create Testimonial
        Testimonial::create([
            'user_id' => $customer->id,
            'rating' => 5,
            'komentar' => 'Rasanya sangat otentik! Mengingatkan saya pada kampung halaman di Ambon.'
        ]);

        // Create Complaint
        Complaint::create([
            'user_id' => $customer->id,
            'subjek' => 'Pesanan Datang Terlambat',
            'isi_keluhan' => 'Mohon maaf pesanan saya datang sedikit terlambat kemarin.',
            'status' => 'Baru'
        ]);

        // Create Favorite
        DB::table('favorites')->insert([
            'user_id' => $customer->id,
            'product_id' => $p1->id
        ]);
    }
}
