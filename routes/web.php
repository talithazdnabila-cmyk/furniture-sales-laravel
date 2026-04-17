<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| CONTROLLERS
|--------------------------------------------------------------------------
*/

// ================= ADMIN =================
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SupplierController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\PengirimanController;
use App\Http\Controllers\Admin\ProfileController;

// ================= PUBLIC =================
use App\Http\Controllers\Public\ProductController as PublicProductController;

// ================= USER =================
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    // Jika user sudah login, redirect ke dashboard user
    if (auth()->check()) {
        return redirect()->route('user.dashboard');
    }
    $products = \App\Models\Product::with('category')->limit(4)->get();
    return view('welcome', compact('products'));
})->name('home');

/*
|--------------------------------------------------------------------------
| PUBLIC PRODUCTS (untuk guest & authenticated users)
|--------------------------------------------------------------------------
*/
Route::get('/products', [\App\Http\Controllers\Public\ProductController::class, 'index'])->name('products');

Route::get('/products/{id}', [PublicProductController::class, 'show'])
    ->name('products.show');

/*
|--------------------------------------------------------------------------
| USER (CUSTOMER) - Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard user
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    /*
    |--------------------------------------------------------------------------
    | USER PRODUCTS
    |--------------------------------------------------------------------------
    */
    Route::get('/user/products', [UserProductController::class, 'index'])
        ->name('user.products');

    Route::get('/user/products/{id}', [UserProductController::class, 'show'])
        ->name('user.products.show');

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT & TRANSAKSI USER
    |--------------------------------------------------------------------------
    */

    // halaman checkout (GET)
    Route::get('/user/checkout', [TransactionController::class, 'showCheckout'])
        ->name('user.checkout.index');

    // proses checkout (POST dari detail produk)
    Route::post('/user/checkout', [TransactionController::class, 'checkout'])
        ->name('user.checkout');

    // konfirmasi & simpan transaksi
    Route::post('/user/checkout/confirm', [TransactionController::class, 'store'])
        ->name('user.checkout.confirm');

    // list & detail transaksi
    Route::get('/user/transaksi', [TransactionController::class, 'index'])
        ->name('user.transactions.index');
    Route::get('/user/transaksi/{id}', [TransactionController::class, 'show'])
        ->name('user.transactions.show');
    Route::post('/user/transaksi/{id}/upload-payment-proof', [TransactionController::class, 'uploadPaymentProof'])
        ->name('user.transactions.upload-payment-proof');

    // API untuk polling status transaksi real-time
    Route::get('/api/transaksi/{id}/status', [TransactionController::class, 'getStatus'])
        ->name('api.transaction.status');


    /*
    |--------------------------------------------------------------------------
    | CART
    |--------------------------------------------------------------------------
    */
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/', [CartController::class, 'store'])->name('store');
        Route::put('/{id}', [CartController::class, 'update'])->name('update');
        Route::delete('/{id}', [CartController::class, 'destroy'])->name('destroy');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::post('/toggle-selected', [CartController::class, 'toggleSelected'])->name('toggleSelected');
        Route::post('/select-all', [CartController::class, 'selectAll'])->name('selectAll');
    });
});

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {
        
        // Dashboard admin
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Profile admin
        Route::get('/profile', [ProfileController::class, 'index'])
            ->name('profile.index');
        Route::post('/profile/update', [ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('/profile/delete', [ProfileController::class, 'destroy'])
            ->name('profile.delete');

        /*
        |--------------------------------------------------------------------------
        | PRODUCTS
        |--------------------------------------------------------------------------
        */
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            Route::get('/create', [ProductController::class, 'create'])->name('create');
            Route::post('/', [ProductController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('edit');
            Route::put('/{id}', [ProductController::class, 'update'])->name('update');
            Route::delete('/{id}', [ProductController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | CATEGORIES
        |--------------------------------------------------------------------------
        */
        Route::prefix('categories')->name('categories.')->group(function () {
            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::get('/create', [CategoryController::class, 'create'])->name('create');
            Route::post('/', [CategoryController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
            Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
            Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
            Route::get('/{id}/products', [CategoryController::class, 'showProducts'])
                ->name('products');
        });

        /*
        |--------------------------------------------------------------------------
        | SUPPLIERS
        |--------------------------------------------------------------------------
        */
        Route::prefix('suppliers')->name('suppliers.')->group(function () {
            Route::get('/', [SupplierController::class, 'index'])->name('index');
            Route::get('/create', [SupplierController::class, 'create'])->name('create');
            Route::post('/', [SupplierController::class, 'store'])->name('store');
            Route::get('/{supplier}/edit', [SupplierController::class, 'edit'])->name('edit');
            Route::put('/{supplier}', [SupplierController::class, 'update'])->name('update');
            Route::delete('/{supplier}', [SupplierController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | USERS (ADMIN)
        |--------------------------------------------------------------------------
        */
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('/{id}', [UserController::class, 'update'])->name('update');
            Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
        });

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI ADMIN
        |--------------------------------------------------------------------------
        */
        Route::resource('transaksi', AdminTransaksiController::class);
        Route::post('/transaksi/{id}/konfirmasi', [AdminTransaksiController::class, 'konfirmasi'])
            ->name('transaksi.konfirmasi');
        Route::post('/transaksi/{id}/tolak', [AdminTransaksiController::class, 'tolak'])
            ->name('transaksi.tolak');
        Route::post('/transaksi/{id}/selesai', [AdminTransaksiController::class, 'selesai'])
            ->name('transaksi.selesai');
        Route::get('/transaksi/payment-proofs/list', [AdminTransaksiController::class, 'paymentProofs'])
            ->name('transaksi.payment-proofs');
        Route::post('/transaksi/{id}/approve-payment-proof', [AdminTransaksiController::class, 'approvePaymentProof'])
            ->name('transaksi.approve-payment-proof');
        Route::post('/transaksi/{id}/reject-payment-proof', [AdminTransaksiController::class, 'rejectPaymentProof'])
            ->name('transaksi.reject-payment-proof');

        /*
        |--------------------------------------------------------------------------
        | PENGIRIMAN ADMIN
        |--------------------------------------------------------------------------
        */
        Route::resource('pengiriman', PengirimanController::class);
        Route::post('/pengiriman/{id}/update-status', [PengirimanController::class, 'updateStatus'])
            ->name('pengiriman.updateStatus');

        /*
        |--------------------------------------------------------------------------
        | REPORT
        |--------------------------------------------------------------------------
        */
        Route::get('/reports/sales', [ReportController::class, 'sales'])
            ->name('reports.sales');
    });

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
