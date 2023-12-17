<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardProductController;
use App\Http\Controllers\TenagaKerjaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//halaman pertama yang tampil
Route::get('/', [HomeController::class, 'index']);

//rute login
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticating']);
Route::post('/logout', [AuthController::class, 'logout']);

// rute regist
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);



Route::get('/dashboard', function () {
    return view('dashboard.index');
});

Route::resource('/dashboard/user', DashboardUserController::class)->middleware('auth');

Route::get('/dashboard/product/checkSlug', [DashboardProductController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/product', DashboardProductController::class)->middleware('auth');

Route::resource('/TenagaKerja', TenagaKerjaController::class)->middleware('tenagaKerja');

Route::get('/cart', function () {
    return view('cart.index');
});
