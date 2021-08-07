<?php

use App\Http\Controllers\Api\LoanController;
use App\Http\Controllers\Auth\Api\LoginController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');
    Route::get('/me', [LoginController::class, 'me'])->middleware('auth:api');
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', [CategoryController::class, 'all']);
});

Route::prefix('books')->group(function () {
    Route::get('/{limit?}', [BookController::class, 'all']);
});

Route::prefix('book')->group(function () {
    Route::get('/{id}', [BookController::class, 'getSingle']);
});

Route::prefix('loan')->middleware('auth:api')->group(function () {
    Route::get('/', [LoanController::class, 'all']);
    Route::get('/{id}', [LoanController::class, 'get']);
    Route::post('/store', [LoanController::class, 'store']);
    Route::post('/abort/{id}', [LoanController::class, 'abort']);
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
