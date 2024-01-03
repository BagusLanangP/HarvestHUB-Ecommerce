<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TokoController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\KonsultanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\CartDetailController;
use App\Http\Controllers\TenagaKerjaController;
use App\Http\Controllers\DashboardUserController;
use App\Http\Controllers\DashboardProductController;

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


// Homepage
Route::get('/cari', [HomeController::class, 'cari']);
//rute login
Route::get('/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'authenticating']);
Route::post('/logout', [AuthController::class, 'logout']);

// rute regist
Route::get('/register', [RegisterController::class, 'index']);
Route::post('/register', [RegisterController::class, 'store']);


Route::middleware(['dashboard'])->get('/dashboard', function () {
    return view('dashboard.index');
});

Route::resource('/cart', CartController::class);

Route::resource('/dashboard/user', DashboardUserController::class)->middleware('auth');

Route::get('/dashboard/product/checkSlug', [DashboardProductController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/product', DashboardProductController::class)->middleware('auth');

Route::resource('/TenagaKerja', TenagaKerjaController::class)->middleware('tenagaKerja');
Route::resource('/Konsultan', KonsultanController::class)->middleware('konsultan');
Route::resource('Toko', TokoController::class)
->middleware('toko');

Route::get('/Toko/{id}', [TokoController::class, 'show']);
Route::get('/Tenagakerja/view', [HomeController::class, 'tenagakerja']);
Route::get('/Ahlipakar/view', [HomeController::class, 'ahlipakar']);





Route::get('/home/kategori/{id}', [HomeController::class, 'categoryDetail']);


Route::get('/produk/{slug}', [HomeController::class, 'produkdetail']);
Route::get('/tenagakerja/{id}', [HomeController::class, 'tenagakerjadetail']);
Route::get('/ahlipakar/{id}', [HomeController::class, 'ahlipakardetail']);

//route untuk user yang sudah melakukan login
Route::group(['middleware' => 'auth'], function(){
    Route::resource('cartdetail', CartDetailController::class);
    Route::resource('wishlist', WishlistController::class);
    Route::get('checkout', [CartController::class,'checkout']);
    Route::patch('kosongkan/{id}', [CartController::class, 'kosongkan']);
    Route::resource('transaksi', TransaksiController::class);
});
