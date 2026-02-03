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
use App\Http\Controllers\Admin\ProfileController;

// ================= USER =================
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\ProductController as UserProductController;
use App\Http\Controllers\User\TransactionController;
use App\Http\Controllers\User\CheckoutController;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    $products = \App\Models\Product::with('category')->limit(4)->get();
    return view('welcome', compact('products'));
})->name('home');

/*
|--------------------------------------------------------------------------
| USER (CUSTOMER)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // Dashboard user
    Route::get('/dashboard', [UserDashboardController::class, 'index'])
        ->name('user.dashboard');

    // Semua produk
    Route::get('/products', [UserProductController::class, 'index'])
        ->name('user.products');

    // Detail produk
    Route::get('/products/{id}', [UserProductController::class, 'show'])
        ->name('user.products.show');

    // Produk berdasarkan kategori
    Route::get('/categories/{id}', [UserProductController::class, 'byCategory'])
        ->name('user.categories.show');

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT & TRANSAKSI USER
    |--------------------------------------------------------------------------
    */

    // halaman checkout (GET)
    Route::get('/checkout', [TransactionController::class, 'showCheckout'])
        ->name('user.checkout.index');

    // proses checkout (POST dari detail produk)
    Route::post('/checkout', [TransactionController::class, 'checkout'])
        ->name('user.checkout');

    // konfirmasi & simpan transaksi
    Route::post('/checkout/confirm', [TransactionController::class, 'store'])
        ->name('user.checkout.confirm');
});

Route::get('/user/transaksi', [TransactionController::class, 'Index'])
    ->name('user.transactions.index');

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
