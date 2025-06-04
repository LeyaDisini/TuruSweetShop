<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;



class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();

        $totalPrice = 100000; //cth buat test API aja, misal harga e 10000, nanti realnya ambil dari cart tp ini gabisa ambil dari cart krn cart skrng session based bukan masuk DB

        //Misal kalo udh integrasi sm FE, msh blm bisa di integrasi krn login bermasalah jadi gabisa detect user skrng siapa dan pny uang brp
        // $user = $request->user();

        // $cart = $request->session()->get('cart', []);

        // $totalPrice = 0;
        // foreach ($cart as $item) {
        //     $totalPrice += $item['price'] * $item['quantity'];
        // }

        if ($user->money < $totalPrice) {
            return response()->json([
                'status' => 'insufficient',
                'message' => 'Saldo tidak cukup.'
            ]);
        }

        DB::beginTransaction();

        try {
            $user->money -= $totalPrice;
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'amount' => $totalPrice,
                'status' => 'success',
                'description' => 'Pembayaran checkout',
            ]);

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Transaksi berhasil.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada server.'
            ], 500);
        }
    }

    public function topup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        $user = Auth::user();
        $user->money += $request->amount;

        $saved = $user->save(); //gtau knp di VS ku kena error "Undefined method 'save' tp klo di test API keupdate kok uangnya
        
        return response()->json([
            'success' => true,
            'message' => 'Top up berhasil',
            'new_balance' => $user->money,
        ]);
    }
}
