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
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AlamatPengirimanController;

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
Route::patch('/dashboard/user/{user}/ban', [DashboardUserController::class, 'ban'])->name('user.ban')->middleware('auth');
Route::get('/dashboard/user/{user}/backup', [DashboardUserController::class, 'backup'])->name('user.backup')->middleware('auth');

Route::get('/dashboard/product/checkSlug', [DashboardProductController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/product', DashboardProductController::class)->middleware('auth');

Route::resource('/TenagaKerja', TenagaKerjaController::class)->middleware('tenagaKerja');
Route::resource('/Konsultan', KonsultanController::class)->middleware('konsultan');
Route::resource('Toko', TokoController::class)->except(['show'])->middleware('toko');

Route::get('/Toko/{id}', [TokoController::class, 'show']);
Route::get('/Tenagakerja/view', [HomeController::class, 'tenagakerja']);
Route::get('/Ahlipakar/view', [HomeController::class, 'ahlipakar']);

Route::get('/home/kategori/{id}', [HomeController::class, 'categoryDetail']);


Route::get('/produk/{slug}', [HomeController::class, 'produkdetail']);
Route::get('/tenagakerja/{slug}', [HomeController::class, 'tenagakerjadetail']);
Route::get('/ahlipakar/{slug}', [HomeController::class, 'ahlipakardetail']);

//route untuk user yang sudah melakukan login
Route::group(['middleware' => 'auth'], function(){
    Route::get('/chat', [HomeController::class, 'chat'])->name('chat');
    Route::resource('cartdetail', CartDetailController::class);
    Route::resource('wishlist', WishlistController::class);
    Route::get('checkout', [CartController::class,'checkout']);
    Route::post('checkout/alamat', [AlamatPengirimanController::class, 'storeAjax'])->name('checkout.alamat.store');
    Route::patch('kosongkan/{id}', [CartController::class, 'kosongkan']);
    Route::resource('transaksi', TransaksiController::class);
    Route::patch('transaksi/{transaction}/complete', [TransaksiController::class, 'complete'])->name('transaksi.complete');
    Route::patch('transaksi/{transaction}/cancel', [TransaksiController::class, 'cancel'])->name('transaksi.cancel');
    Route::get('transaksi/{id}/nota', [TransaksiController::class, 'nota'])->name('transaksi.nota');
    
    Route::get('review/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('review/store', [ReviewController::class, 'store'])->name('review.store');
    
    // User role requests
    Route::get('role-requests/create', [\App\Http\Controllers\RoleRequestController::class, 'create'])->name('role_requests.create');
    Route::post('role-requests', [\App\Http\Controllers\RoleRequestController::class, 'store'])->name('role_requests.store');
});

// Admin role requests (assuming 'dashboard' middleware protects admin area)
Route::middleware(['dashboard'])->group(function () {
    Route::get('dashboard/role-requests', [\App\Http\Controllers\RoleRequestController::class, 'index'])->name('dashboard.role_requests.index');
    Route::get('dashboard/role-requests/{roleRequest}', [\App\Http\Controllers\RoleRequestController::class, 'show'])->name('dashboard.role_requests.show');
    Route::put('dashboard/role-requests/{roleRequest}', [\App\Http\Controllers\RoleRequestController::class, 'update'])->name('dashboard.role_requests.update');
    
    // Admin Analytics
    Route::get('dashboard/analytics', [\App\Http\Controllers\AdminAnalyticsController::class, 'index'])->name('dashboard.analytics.index');
});
