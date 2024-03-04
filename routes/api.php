<?php

use App\Http\Middleware\ApiMiddleware;
use App\Http\Middleware\VerifyCsrfToken;
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

Route::group(['throttle:30,1'], function () {
    Route::get('/condizioni', [App\Http\Controllers\ApiController::class, 'condizioni']);
    Route::get('/autori/{query}', [App\Http\Controllers\ApiController::class, 'autori']);

    Route::get('search/{query}', [App\Http\Controllers\ApiController::class, 'searchSuggestions']);
    Route::get('barcode/{libro_id}', [App\Http\Controllers\ApiController::class, 'barcode']);

    Route::post('recensioni', [App\Http\Controllers\ApiController::class, 'recensioni']);
    Route::post('prenotazione', [App\Http\Controllers\ApiController::class, 'prenotazione']);

    Route::post('get_books/page={page}/query={query}/orderby={orderby}/genere={genere}/autore={autore}/editore={editore}/nazione={nazione}/sezione={sezione}', [App\Http\Controllers\ApiController::class, 'get_books']);
});
