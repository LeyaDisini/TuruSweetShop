<?php

use App\Http\Controllers\Ccart;
use App\Http\Controllers\Cuser;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

// Route::get('/home', function () {
//     return view('home');
// })->name('home');

Route::get('/admin/index', function () {
    return view('admin.index');
})->name('admin/index');

Route::get('/admin/tambah', function () {
    return view('admin.tambah');
})->name('admin/tambah');

Route::get('/admin/detail', function () {
    return view('admin.detail');
})->name('admin/detail');

Route::get('/menu', function () {
    return view('products.index');
})->name('menu');


// Route::get('/produk/{product}/edit', [ProductsController::class, 'edit'])->name('products.edit');
// Route::put('/produk/{product}', [ProductsController::class, 'update'])->name('products.update');

// Route::delete('/produk/{id}', [ProductsController::class, 'destroy'])->name('products.destroy');

// Route::get('/admin/tambah', [ProductsController::class, 'create'])->name('admin.tambah');
// Route::post('/admin/tambah', [ProductsController::class, 'store'])->name('products.store');

Route::controller(ProductsController::class)->group(function () {
    Route::get('/produk/{product}/edit', 'edit')->name('products.edit');
    Route::put('/produk/{product}', 'update')->name('products.update');
});

Route::get('admin/tambah', function () {
    return view('admin.tambah'); // nama file blade form kamu, sesuaikan
});

Route::get('/home', [Cuser::class, 'index']);



Route::get('/cart/data', [Ccart::class, 'getCart']);
Route::post('/cart/add', [Ccart::class, 'add']);
Route::post('/cart/update', [Ccart::class, 'update']);
Route::post('/cart/remove', [Ccart::class, 'remove']);
