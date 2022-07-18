<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;

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

Route::group(['middleware'=>['auth:sanctum']],function () {
Route::post('logout' , [UserController::class , 'logout']);
Route::get('user/profile' , [UserController::class , 'profile']);
Route::post('product' , [ProductController::class , 'store']);
Route::post('product/{id}/comment' , [ProductController::class , 'storecomments']);
});
Route::post('/register' , [UserController::class , 'register']);
Route::post('/login' , [UserController::class , 'login']);

Route::prefix('product')->group(function(){
Route::get('/' , [ProductController::class , 'index']);
Route::post('update/{id}' , [ProductController::class , 'update']);
Route::post('delet/{id}' , [ProductController::class , 'destroy']);
Route::get('/{id}' , [ProductController::class  , 'show']);

Route::post('/search' , [ProductController::class , 'search']);
Route::post('/sort' , [ProductController::class , 'sort']);
});
//Route::get('show' , [UserController::class , 'show']);
//Route::get('product/{id}'  , [ProductController::class , 'show']);
//Route::get('product'  , [ProductController::class , 'index']);
//Route::post('createcategory' , [ProductController::class , 'creatcategory']);




