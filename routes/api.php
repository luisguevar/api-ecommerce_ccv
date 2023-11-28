<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Ecommerce\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JWTController;
use App\Http\Controllers\Product\CategorieController;
use App\Http\Controllers\Product\ImageController;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Slider\SliderController;
use App\Http\Controllers\UserController;
use App\Models\Products\ProductImage;


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

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::group(['prefix' => 'users'], function ($router) {
    Route::post('/register', [JWTController::class, 'register']);
    Route::post('/login', [JWTController::class, 'loginAdmin']);
    Route::post('/login_ecommerce', [JWTController::class, 'loginEcommerce']);
    Route::post('/logout', [JWTController::class, 'logout']);
    Route::post('/refresh', [JWTController::class, 'refresh']);
    Route::post('/profile', [JWTController::class, 'profile']);

    Route::group(['prefix' => 'admin'], function ($router) {
        Route::post('/register', [UserController::class, 'store']);
        Route::get('/all', [UserController::class, 'index']);
        Route::put('/update/{id}', [UserController::class, 'edit']);
        Route::delete('/delete/{id}', [UserController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'products'], function ($router) {

    Route::get('/getCategorias', [ProductController::class, 'getCategorias']);
    Route::post('/add', [ProductController::class, 'store']);
    Route::get('/all', [ProductController::class, 'index']);
    Route::get('/show_product/{id}', [ProductController::class, 'show']);
    Route::post('/update/{id}', [ProductController::class, 'update']);

    Route::group(['prefix' => 'imgs'], function ($router) {
        Route::post('/add', [ImageController::class, 'store']);
        Route::delete('/delete/{id}', [ImageController::class, 'destroy']);
    });


    Route::group(['prefix' => 'categories'], function ($router) {

        Route::get('/all', [CategorieController::class, 'index']);
        Route::post('/add', [CategorieController::class, 'store']);
        Route::post('/update/{id}', [CategorieController::class, 'update']);
        Route::delete('/delete/{id}', [CategorieController::class, 'destroy']);
    });
});

Route::group(['prefix' => 'sliders'], function ($router) {
    Route::get('/all', [SliderController::class, 'index']);
    Route::post('/add', [SliderController::class, 'store']);
    Route::post('/update/{id}', [SliderController::class, 'update']);
    Route::delete('/delete/{id}', [SliderController::class, 'destroy']);
});


Route::group(['prefix' => 'ecommerce'], function ($router) {
    Route::get('/home', [HomeController::class, 'index']);
    Route::get('/detail-product/{slug}', [HomeController::class, 'detail_product']);

    Route::group(['prefix' => 'cart'], function ($router) {
        Route::resource("add", CartController::class);
    });
});
