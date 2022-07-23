<?php

use App\Http\Controllers\API\productController;
use App\Http\Controllers\API\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\product;

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

// protected route
Route::get('/product',[productController::class,'index']);
Route::get('/product/{id}',[productController::class,'show']);
Route::get('product/search/{$name}',[productController::class,'search']);
Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::group(['middleware'=>['auth:sanctum']], function (Request $request) {
    //     // return $request->user();
    // Route::get('/product',[productController::class,'index']);
    
    // });
    
    // protected route
    Route::group(['middleware' => ['auth:sanctum']], function() {
        Route::post('/product',[productController::class,'store']); 
        Route::put('/product/{id}',[productController::class,'update']);
        Route::delete('/product/{id}',[productController::class,'destroy']);
        Route::post('/logout',[AuthController::class,'logout']);

    
   });