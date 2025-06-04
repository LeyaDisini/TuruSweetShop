<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Products;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'id' => (string) Str::uuid(),
            'name' => 'admin BNCC',
            'email' => 'adminBNCC@gmail.com',
            'password' => Hash::make('Admin123!'),
            'is_admin' => true,
        ]);

        $products = [
            [
                'name' => 'Cube Toast (Medium)',
                'desc' => 'Golden-browned toast cubes with a soft center, buttery aroma, and a sweet dusting of powdered sugar. Perfect for cozy bite anytime.',
                'price' => 28000,
                'stock' => 50,
                'image' => 'CubeToast.png',
            ],
            [
                'name' => 'Waffle Stick (Per Stick)',
                'desc' => 'Golden waffle on a stick, dipped in rich chocolate for a warm, sweet hug in every bite.',
                'price' => 8000,
                'stock' => 30,
                'image' => 'WaffleStick.png',
            ],
            [
                'name' => 'Milk Panna Cotta',
                'desc' => 'Silky milk-based panna cotta with a delicate valinla or honey twist perfect for a chill night treat/',
                'price' => 12000,
                'stock' => 20,
                'image' => 'MilkPannaCotta.png',
            ],
            [
                'name' => 'Meltie Milk',
                'desc' => 'Homemade milk candy with a hint of vanila or honey. Nostalgic and comforting just like warm milk before bed.',
                'price' => 18000,
                'stock' => 30,
                'image' => 'MeltieMilk.png',
            ],
            [
                'name' => 'Turu Cocoa',
                'desc' => 'Homemade hot chocolate powder blend with a touch of cinnamon, comforting and rich.',
                'price' => 28000,
                'stock' => 50,
                'image' => 'TuruCocoa.png',
            ],
            [
                'name' => 'Cozy Cookie Bites (3 pcs)',
                'desc' => 'Baked to perfection, each cookie features premium ingredients and irresistible melting chocolate chips.',
                'price' => 15000,
                'stock' => 20,
                'image' => 'CozyCookieBites.png',
            ],
        ];

        foreach ($products as $item) {
            $filename = $item['image'];
            $sourcePath = base_path('database/seeders/sample_images/' . $filename);

            // Copy gambar ke storage/public/images
            Storage::disk('public')->putFileAs('images', new \Illuminate\Http\File($sourcePath), $filename);

            // Simpan ke database
            Products::create([
                'id' => (string) Str::uuid(),
                'name' => $item['name'],
                'price' => $item['price'],
                'desc' => $item['desc'],
                'stock' => $item['stock'],
                'image' => 'storage/images/' . $filename,
            ]);
        }
    }
}
