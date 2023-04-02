<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartDetailController;
use App\Http\Controllers\Api\HeartController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PostPicAndVideoController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/updateProfile', [UserController::class, 'updateProfile']);
    Route::post('/createPost/home', [PostPicAndVideoController::class, 'home']);
    Route::get('/display-user-posts', [PostPicAndVideoController::class, 'display_user_posts']);
    Route::get('/post/{id}', [PostPicAndVideoController::class, 'getPostById']);

    Route::get('/searchPosts/{searchable}', [PostPicAndVideoController::class, 'search']);
    Route::get('/addToCart', [CartController::class, 'cart']);
    Route::post('/deleteAllItemCart', [CartController::class, 'deleteAllItemCartDetail']);
    Route::get('/showCartDetail', [CartDetailController::class, 'showAllCartDetail']);
    Route::post('/removeCartDetail', [CartDetailController::class, 'removeCartDetail']);

    Route::get('/messages/{id}', [MessageController::class, 'showMessages']);
    Route::post('/messages/add', [MessageController::class, 'addMessage']);


    // product
    Route::post('/addProduct', [PostPicAndVideoController::class, 'addProduct']);


    Route::post('/like', [HeartController::class, 'like']);
    Route::get('/count-like-post', [HeartController::class, 'count']);
    Route::get('/me', [AuthController::class, 'me']);

});


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/test', [AuthController::class, 'test']);
