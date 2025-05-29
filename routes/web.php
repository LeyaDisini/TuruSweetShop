<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/menu', function () {
    return view('products.index');
})->name('menu');

// Route::get('/admin/index', function () {
//     return view('admin.index');
// })->name('admin/index');

// Route::get('/admin/tambah', function () {
//     return view('admin.tambah');
// })->name('admin/tambah');

// Route::get('/admin/edit', function () {
//     return view('admin.edit');
// })->name('admin/edit');

// Route::get('/admin/detail', function () {
//     return view('admin.detail');
// })->name('admin/detail');
