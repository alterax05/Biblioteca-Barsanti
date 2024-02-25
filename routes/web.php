<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Mail\Test;
use Illuminate\Support\Facades\Mail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\IndexController::class, 'index'])->name('home');
Route::get('/faq', [App\Http\Controllers\IndexController::class, 'faq'])->name('faq');
Route::get('/mappa', [App\Http\Controllers\IndexController::class, 'mappa'])->name('mappa');

Route::group(['prefix' => 'proponi', 'middleware' => 'auth', 'as' => 'proponi'], function () {
    Route::get('/', [App\Http\Controllers\IndexController::class, 'proponi'])->name('proponi.get');;
    Route::post('/', [App\Http\Controllers\IndexController::class, 'proponiPost'])->name('proponi.post');;
});

Route::get('/nazioni', [App\Http\Controllers\IndexController::class, 'nazioni'])->name('nazioni');
Route::get('/autori/{lettera}', [App\Http\Controllers\IndexController::class, 'autori'])->name('autori');


Route::group(['prefix' => 'search', 'as' => 'catalogo.'], function () {
    Route::get('', [App\Http\Controllers\BookController::class, 'index']);
    Route::get('/autore/{author}', [App\Http\Controllers\BookController::class, 'autore']);
    Route::get('/nazione/{nazione}', [App\Http\Controllers\BookController::class, 'nazioni']);
    Route::get('/sezione/{sezione}', [App\Http\Controllers\BookController::class, 'sezione']);
});

Route::group(['prefix' => 'book', 'as' => 'book.'], function () {
    Route::get('{id_book}', [App\Http\Controllers\BookController::class, 'single']);
});

Route::group(['prefix' => 'admin', 'middleware' => 'admin', 'as' => 'admin.'], function () {
    Route::get('/', ['as' => 'index', 'uses' => 'App\Http\Controllers\AdminController@index']);
    Route::get('/books/generate', [App\Http\Controllers\AdminController::class, 'generate']);

    Route::get('/presta', ['as' => 'presta', 'uses' => 'App\Http\Controllers\AdminController@presta']);
    Route::post('/presta', [App\Http\Controllers\AdminController::class, 'prestaPost']);

    Route::get('/prestiti', ['as' => 'prestiti', 'uses' => 'App\Http\Controllers\AdminController@prestiti']);
    Route::get('/prenota', ['as' => 'prenota', 'uses' => 'App\Http\Controllers\AdminController@prenota']);
    Route::get('/completa', ['as' => 'completa', 'uses' => 'App\Http\Controllers\AdminController@completi']);

    Route::get('/insert', ['as' => 'insert', 'uses' => 'App\Http\Controllers\AdminController@insertGet'])->name('insert.get');
    Route::post('/insert', [App\Http\Controllers\AdminController::class, 'insert'])->name('insert.post');

    Route::get('/book/{ISBN}/{codice}', [App\Http\Controllers\AdminController::class, 'book']);
    Route::post('/book/{ISBN}/authors', [App\Http\Controllers\AdminController::class, 'authors']);

    Route::get('/insert/advanced', ['as' => 'insert', 'uses' => 'App\Http\Controllers\AdminController@indexAdvanced'])->name('insert.advanced.get');
    Route::post('/insert/advanced', [App\Http\Controllers\AdminController::class, 'advancedPost'])->name('insert.advanced.post');

    Route::post('/insert/{ISBN}', [App\Http\Controllers\AdminController::class, 'insertPost'])->name('insert.post');

    Route::post('/restituisci', [App\Http\Controllers\AdminController::class, 'restituisci']);

    Route::get('/proposte', ['as' => 'proposte', 'uses' => 'App\Http\Controllers\AdminController@proposte']);
    Route::get('/bacheca', ['as' => 'bacheca', 'uses' => 'App\Http\Controllers\AdminController@bacheca']);
    Route::post('/bacheca', [App\Http\Controllers\AdminController::class, 'bachecaAdd']);
    Route::get('/bacheca/delete/{id_autore}', [App\Http\Controllers\AdminController::class, 'bachecaDelete']);

});

Route::get('/add_user/{nome}/{cognome}/{email}/{dipartimento}', [App\Http\Controllers\ProfileController::class, 'add_user']);


Route::group(['prefix' => 'post', 'middleware' => 'auth'], function () {
    Route::get('preferiti/{ISBN}', [App\Http\Controllers\IndexController::class, 'preferiti']);
});

Route::get('/insertApp/{ISBN}', [App\Http\Controllers\AdminController::class, 'insertApp']);

Route::group(['prefix' => 'profile', 'middleware' => 'auth', 'as' => 'profile.'], function () {
    Route::get('/', [App\Http\Controllers\ProfileController::class, 'profile'])->name('prestiti');
    Route::get('/preferiti', [App\Http\Controllers\ProfileController::class, 'preferiti'])->name('preferiti');
    Route::get('/restituiti', [App\Http\Controllers\ProfileController::class, 'restituiti'])->name('restituiti');
    Route::get('/prenotati', [App\Http\Controllers\ProfileController::class, 'prenotati'])->name('prenotati');
    Route::get('/generate', [App\Http\Controllers\ProfileController::class, 'generate']);
});

Route::group(['prefix' => '/api/admin', 'middleware' => 'admin'], function () {
    Route::get('search/{ISBN}', [App\Http\Controllers\ApiController::class, 'adminSearch']);
    Route::get('restituisci/{ISBN}', [App\Http\Controllers\ApiController::class, 'restituisci']);
});

Route::get('/login/redirect', [\App\Http\Controllers\Auth\LoginController::class, 'redirectToProvider']);
Route::get('/login/callback', [\App\Http\Controllers\Auth\LoginController::class, 'handleProviderCallback']);

Route::get('/login', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('login');

Route::group(['prefix' => 'documentaries', 'middleware' => 'auth', 'as' => 'documentaries.'], function () {
    Route::get('/{docum}', [App\Http\Controllers\DocumentariController::class, 'index']);
    Route::get('/list/{reparto?}', [App\Http\Controllers\DocumentariController::class, 'list']);
    Route::post('/', [App\Http\Controllers\DocumentariController::class, 'add']);
});

Route::get('language/{locale}', function ($locale) {
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});

Route::get('covers/{ISBN}', [App\Http\Controllers\ImageController::class, 'getCover']);

Route::get('/testroute', function() {
    $name = "Funny Coder";

    // The email sending is done using the to method on the Mail facade
    Mail::to('giovanni.dequattro@barsanti.edu.it')->send(new Test($name));
});