<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BagController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewsController;
use App\Http\Controllers\ShoppingAddressController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/verify', [UserController::class, 'verify']);
Route::post('/search-order', [OrderController::class, 'search']);
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories-product/{id}', [CategoryController::class, 'categoryProduct']);
Route::put('/forgot', [UserController::class, 'forgotPassword']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::get('/like-product/{id}', [ProductController::class, 'like']);
Route::get('/reviews/{id}', [ReviewsController::class, 'userReviews']);
Route::get('/order-items/{id}', [OrderController::class, 'OrderItem']);


Route::middleware('auth:api')->group(function () {
    Route::get('me', [UserController::class, 'me']);
    Route::get('/new-orders', [OrderController::class, 'index']);
    Route::get('/all-orders', [OrderController::class, 'orders']);
    Route::get('/confirm-order/{id}', [OrderController::class, 'confirm']);
    Route::get('/confirm-orders', [OrderController::class, 'confirmed']);
    Route::get('/cancel-order/{id}', [OrderController::class, 'cancel']);
    Route::get('/cancel-orders', [OrderController::class, 'cancelled']);
    Route::get('/delivered-orders', [OrderController::class, 'delivered']);
    Route::get('/user-orders', [OrderController::class, 'userOrders']);
    Route::put('/update-profile', [UserController::class, 'updateProfile']);
    Route::post('/new-review', [ReviewsController::class, 'newReviews']);
    Route::get('/wishList', [WishListController::class, 'show']);
    Route::get('/users', [AdminController::class, 'index']);
    Route::post('/reports', [AdminController::class, 'reports']);
    Route::post('/new-product', [ProductController::class, 'store']);
    Route::put('/edit-product/{id}', [ProductController::class, 'update']);
    Route::get('/shopping-cart', [BagController::class, 'index']);
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy']);
    Route::get('/reports', [AdminController::class, 'reports']);
    Route::get('/logout', [UserController::class, 'logout']);
    Route::post('/search-order', [OrderController::class, 'searchOrders']);
    Route::post('/add-card', [BagController::class, 'addToBag']);
    Route::delete('/delete-bag/{id}', [BagController::class, 'destroy']);
    Route::delete('/delete-review/{id}', [ReviewsController::class, 'destroy']);
    Route::delete('/update-review/{id}', [ReviewsController::class, 'update']);
    Route::post('/charge', [StripeController::class, 'charge']);
    Route::post('/stripe', [StripeController::class, 'stripePost'])->name('stripe.post');
    Route::post('/shipping-address', [ShoppingAddressController::class, 'store'])->name('shipping');
});
