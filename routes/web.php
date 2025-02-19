<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {

    //user
    Route::get('/create', [UserController::class, 'create']);
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/user/picture', [UserController::class, 'user_picture']);
    Route::get('/home', [UserController::class, 'home']);
    Route::post('/search', [UserController::class, 'search']);
    
    Route::get('/checkout', [AuthenticatedSessionController::class, 'destroy']);
    
    // home
    Route::post('/create', [ProductController::class, 'create']);
    Route::group(['prefix' => 'home'], function () {
        Route::get('/index', [ProductController::class, 'homeindex']);
        Route::get('/delete/{id}', [ProductController::class, 'delete']);
        Route::get('/edit/{id}', [ProductController::class, 'edit']);
        Route::post('/update/{id}', [ProductController::class, 'update']);
        Route::get('/product/{id}', [ProductController::class, 'product']);
        Route::get('/add-to-cart/product/{id}', [ProductController::class, 'AddToCart']);
        Route::get('/cart', [ProductController::class, 'cart']);
        Route::get('/add-to-cart/delete/{id}', [ProductController::class, 'AddToCartDelete']);
    });

    //payment
    Route::get('/process-payment', [ProductController::class, 'Payment'])->name('process.payment');
    Route::post('/store-payment', [ProductController::class, 'storePayment'])->name('store.payment');
    
  
    // password
    Route::group(['prefix' => 'password'], function () {
        Route::get('/', [UserController::class, 'password']);
        Route::post('/update', [UserController::class, 'password_update']);
    });
        
});

require __DIR__ . '/auth.php';