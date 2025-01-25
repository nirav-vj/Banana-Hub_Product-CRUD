<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\BananahubController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware('auth')->group(function () {

    Route::get('/create', [UserController::class, 'create']);
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/user/picture', [UserController::class, 'user_picture']);
    Route::get('/home', [UserController::class, 'home']);
    Route::post('/search', [UserController::class, 'search']);

    // home
    Route::post('/create', [BananahubController::class, 'create']);
    Route::group(['prefix' => 'home'], function () {
        Route::get('/index', [BananahubController::class, 'homeindex']);
        Route::get('/delete/{id}', [BananahubController::class, 'delete']);
        Route::get('/edit/{id}', [BananahubController::class, 'edit']);
        Route::post('/update/{id}', [BananahubController::class, 'update']);
        Route::get('/product/{id}', [BananahubController::class, 'product']);
        Route::get('/add-to-cart/product/{id}', [BananahubController::class, 'AddToCart']);
        Route::get('/cart', [BananahubController::class, 'cart']);
        Route::get('/add-to-cart/delete/{id}', [BananahubController::class, 'AddToCartDelete']);
    });

    // password
    Route::group(['prefix' => 'password'], function () {
        Route::get('/', [UserController::class, 'password']);
        Route::post('/update', [UserController::class, 'password_update']);
    });

    Route::get('/checkout', [AuthenticatedSessionController::class, 'destroy']);

});

require __DIR__.'/auth.php';
