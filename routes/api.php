<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\QuotesController;
use App\Http\Controllers\Api\LoginController;

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

Route::post('/login', [LoginController::class, 'index'])->name('api.login');


Route::group(['middleware' => ['auth:sanctum'], 'prefix' => 'v1'], function () {
    Route::get('quotes/{length?}', [QuotesController::class, 'index'])->name('list.quotes');
    Route::post('quotes/favorite', [QuotesController::class, 'saveFavorite'])->name('save.favorite');
    Route::get('quotes/favorite/list', [QuotesController::class, 'listFavorite'])->name('list.favorite');
    Route::delete('quotes/favorite/delete/{favorite}', [QuotesController::class, 'deleteFavorite'])->name('delete.favorite');
});
