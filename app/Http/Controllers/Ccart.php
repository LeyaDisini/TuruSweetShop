<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use Illuminate\Support\Facades\Auth;

class Ccart extends Controller
{
    public function add(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = intval($request->input('quantity', 1));
        $product = Products::find($productId);

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Jumlah harus minimal 1']);
        }

        $stock = $product->stock;
        $cart = session()->get('cart', []);

        // Hitung total quantity jika sudah ada di cart
        $currentQuantity = isset($cart[$productId]) ? $cart[$productId]['quantity'] : 0;
        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $stock) {
            return response()->json([
                'success' => false,
                'message' => "Jumlah pesanan melebihi stok yang tersedia. Stok maksimal: $stock"
            ]);
        }

        $cart[$productId] = [
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => $newQuantity,
            'image' => $product->image
        ];

        session(['cart' => $cart]);

        return response()->json(['success' => true, 'message' => 'Produk ditambahkan ke keranjang']);
    }


    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = intval($request->input('quantity', 1));
        if ($quantity < 1) {
            return response()->json(['success' => false, 'message' => 'Jumlah harus minimal 1']);
        }

        $cart = session()->get('cart', []);
        if (!isset($cart[$productId])) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ada di keranjang']);
        }

        $product = Products::find($productId);
        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Produk tidak ditemukan'], 404);
        }

        $stock = $product->stock;

        if ($quantity > $stock) {
            return response()->json([
                'success' => false,
                'message' => "Jumlah pesanan melebihi stok yang tersedia. Stok maksimal: $stock"
            ]);
        }

        $cart[$productId]['quantity'] = $quantity;
        session(['cart' => $cart]);

        return response()->json(['success' => true]);
    }


    public function remove(Request $request)
    {
        $productId = $request->input('product_id');
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session(['cart' => $cart]);
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Produk tidak ada di keranjang']);
    }

    // Fungsi untuk ambil data keranjang (bisa dipakai di AJAX popup)
    public function getCart()
    {
        $cart = session()->get('cart', []);
        return response()->json(['success' => true, 'cart' => $cart]);
    }

    public function showInvoice()
    {
        $cart = session()->get('cart', []);
        return view('payment.invoice', compact('cart'));
    }

    public function checkout()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'status' => 'not_logged_in',
                'message' => 'Silakan login terlebih dahulu.'
            ], 401);
        }

        //Pake ini klo udh integrasi sm FE (ambil total dr cart base on session) -> gamungkin bisa ngeluarin JSON skalopun dana mencukupi
        $cart = session('cart', []);
        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        if ($user->money < $total) {
            return response()->json([
                'status' => 'topup_required',
                'message' => 'Saldo Anda kurang, silakan lakukan topup.'
            ]);
        }

        $user->money -= $total;
        $user->save();

        session()->forget('cart');

        return response()->json(['status' => 'success']);
    }
}
