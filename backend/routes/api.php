<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\CouponsController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\SellersProductController;
use App\Http\Controllers\BelongToController;
use App\Http\Controllers\HasCouponController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::apiResource('/products', ProductController::class);
Route::get('/products', [ProductController::class, 'index']); 
Route::post('/products', [ProductController::class, 'store']); 
Route::get('/products/{id}', [ProductController::class, 'show']); 
Route::put('/products/{id}', [ProductController::class, 'update']); 
Route::delete('/products/{id}', [ProductController::class, 'destroy']); 
Route::get('/order/products/customer/{id}', [ProductController::class, 'orderProductCustomer']);
Route::get('/order/products/seller/{id}', [ProductController::class, 'orderProductSeller']);

Route::get('/seller', [SellerController::class, 'index']);
Route::post('/seller', [SellerController::class, 'store']);
Route::get('/seller/products/{id}', [SellersProductController::class, 'show']);

// Route::apiResource('/member', MemberController::class);
Route::get('/members', [MemberController::class, 'index']); 
Route::post('/members', [MemberController::class, 'store']); 
Route::get('/members/{id}', [MemberController::class, 'show']); 
Route::put('/members/{id}', [MemberController::class, 'update']); 
Route::delete('/members/{id}', [MemberController::class, 'destroy']); 

Route::get('/customer', [CustomerController::class, 'index']);
Route::post('/customer', [CustomerController::class, 'store']);

Route::apiResource('/administrator', AdministratorController::class);

Route::get('/coupons', [CouponsController::class, 'index']);
Route::get('/coupons/{id}', [CouponsController::class, 'show']);
Route::post('/coupons', [CouponsController::class, 'store']);
Route::put('/coupons/{id}', [CouponsController::class, 'update']);
Route::delete('/coupons/{id}', [CouponsController::class, 'destroy']);
// Route::apiResource('/orders', OrdersController::class);
Route::get('/orders', [OrdersController::class, 'index']); 
Route::post('/orders', [OrdersController::class, 'store']); 
Route::get('/orders/{id}', [OrdersController::class, 'show']); 
Route::put('/orders/{id}', [OrdersController::class, 'update']); 
Route::delete('/orders/{id}', [OrdersController::class, 'destroy']); 

Route::get('/belongto', [BelongToController::class, 'index']);
Route::post('/belongto', [BelongToController::class, 'store']);
Route::get('/products/orders/{id}', [BelongToController::class, 'show']);
Route::put('/belongto', [BelongToController::class, 'update']);
Route::delete('/belongto', [BelongToController::class, 'destroy']);

Route::get('/hascoupon', [HasCouponController::class, 'index']);
Route::post('/hascoupon', [HasCouponController::class, 'store']);
Route::get('/hascoupon/{id}', [HasCouponController::class, 'show']);
Route::put('/hascoupon', [HasCouponController::class, 'update']);
Route::delete('/hascoupon', [HasCouponController::class, 'destroy']);

Route::get('/search', [ProductController::class, 'searchItem']);
Route::get('/statics/{id}', [SellersProductController::class, 'statics']);