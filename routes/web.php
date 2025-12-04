<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\MatakuliahController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/pcr', function () {
    return 'Selamat Datang di Website Kampus PCR!';
});

Route::get('/mahasiswa', function () {
    return 'Halo Mahasiswa';
})->name('mahasiswa.show');

Route::get('/nama/{param1}', function ($param1) {
    return 'Nama saya: ' . $param1;
});

Route::get('/nim/{param1?}', function ($param1 = '') {
    return 'NIM saya: ' . $param1;
});

Route::get('/mahasiswa/{param1}', [MahasiswaController::class, 'show']);

Route::get('/about', function () {
    return view('halaman-about');
})->name('route.about');

Route::get('/matakuliah/{param1}', [MatakuliahController::class, 'show']);

Route::get('/home', [HomeController::class, 'index'])
    ->name('home');

Route::post('question/store', [QuestionController::class, 'store'])
    ->name('question.store');

Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::resource('pelanggan', PelangganController::class);

Route::resource('user', UserController::class);

Route::post('/pelanggan/upload-files', [PelangganController::class, 'uploadFiles'])
    ->name('pelanggan.upload-files');

Route::delete('/pelanggan/file/{fileId}', [PelangganController::class, 'deleteFile'])
    ->name('pelanggan.delete-file');

Route::get('auth', [AuthController::class, 'index'])
    ->name('auth');

Route::post('auth/login', [AuthController::class, 'login'])
    ->name('auth.login');

Route::get('auth/logout', [AuthController::class, 'logout'])->name('auth.logout');
