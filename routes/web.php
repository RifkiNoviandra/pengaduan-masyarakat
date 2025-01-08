<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin/Petugas
Route::prefix('admin')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        Route::get('/', 'DashboardController@index')->name('dashboard');

        Route::resource('pengaduans', 'PengaduanController');

        Route::resource('tanggapan', 'TanggapanController');

        Route::get('masyarakat', 'AdminController@masyarakat');
        Route::resource('petugas', 'PetugasController');

        Route::get('laporan', 'AdminController@laporan');
        Route::get('laporan/cetak', 'AdminController@cetak');
        Route::get('pengaduan/cetak/{id}', 'AdminController@pdf');
    });


// Masyarakat
Route::prefix('user')
    ->middleware(['auth', 'MasyarakatMiddleware'])
    ->group(function () {
        Route::get('/', 'MasyarakatController@index')->name('masyarakat-dashboard');
        Route::resource('pengaduan', 'MasyarakatController');
        Route::get('pengaduan', 'MasyarakatController@lihat');
    });

Route::resource('donations', 'DonationController')->middleware(['auth', 'MasyarakatMiddleware']);

Route::resource('posts', 'PostController')->middleware(['auth', 'MasyarakatMiddleware']);

Route::middleware(['auth', 'MasyarakatMiddleware'])->post('/posts/{post}/comments', 'PostController@storeComment')->name('comments.store');

Route::middleware(['auth', 'MasyarakatMiddleware'])->post('/comments/{comment}/reactions', 'PostController@addReaction')->name('comments.reactions.store');





require __DIR__ . '/auth.php';
