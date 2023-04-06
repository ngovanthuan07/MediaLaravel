<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartDetailController;
use App\Http\Controllers\Api\HeartController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\PostPicAndVideoController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\RoomController;
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
    // logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // profile
    Route::post('/updateProfile', [UserController::class, 'updateProfile']);
    Route::get('/me', [AuthController::class, 'me']);

    // post
    Route::post('/createPost/home', [PostPicAndVideoController::class, 'home']);
    Route::post('/createPostRoom', [PostPicAndVideoController::class, 'createPostRoom']);
    Route::get('/display-user-post-product', [PostPicAndVideoController::class, 'display_user_post_and_product']);
    Route::get('/display-posts', [PostPicAndVideoController::class, 'display_posts']);

    Route::get('/post/{id}', [PostPicAndVideoController::class, 'getPostById']);

    //cart
    Route::get('/addToCart', [CartController::class, 'cart']);
    Route::post('/deleteAllItemCart', [CartController::class, 'deleteAllItemCartDetail']);
    Route::get('/showCartDetail', [CartDetailController::class, 'showAllCartDetail']);
    Route::post('/removeCartDetail', [CartDetailController::class, 'removeCartDetail']);

    // message
    Route::get('/messages/{id}', [MessageController::class, 'showMessages']);
    Route::post('/messages/add', [MessageController::class, 'addMessage']);

    // room
    Route::post('/createRoom', [RoomController::class, 'createRoom']);
    Route::post('/showRoom', [RoomController::class, 'showRoom']);
    Route::post('/showPostRoom', [RoomController::class, 'showPostRoom']);
    Route::post('/inviteMember', [RoomController::class, 'inviteMember']);
    Route::get('/showAllRoom', [RoomController::class, 'showAllRoom']);
    Route::get('/showRoom/{id}', [RoomController::class, 'showRoom']);
    Route::get('/room/post', [RoomController::class, 'showRoom']);

    // product
    Route::post('/addProduct', [ProductController::class, 'addProduct']);
    Route::get('/product/{id}', [ProductController::class, 'show_product_by_id']);

    // like
    Route::post('/like', [HeartController::class, 'like']);
    Route::get('/count-like-post', [HeartController::class, 'count']);

    // search
    Route::post('/searchUserByField', [UserController::class, 'search']);
    Route::get('/searchable/{searchable}', [PostPicAndVideoController::class, 'search']);

});

// login and register
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
