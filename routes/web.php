<?php

use Illuminate\Support\Facades\Route;

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

Route::get('testes', function (){
    $numero = 0.29;
    $return = \App\Helpers\stringFloatToCents($numero);
    dd(\App\Helpers\showCentsValue($return));
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/vue-teste', function () {
    return view('vue-teste');
});

Auth::routes();

Route::middleware('auth')->group(function (){
    Route::get('/home'                        , [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/products'             , \App\Http\Controllers\ProductController::class);
    Route::resource('/customers'            , \App\Http\Controllers\CustomerController::class);
    Route::resource('/aditionals'           , \App\Http\Controllers\AditionalController::class);
    Route::resource('/orders'               , \App\Http\Controllers\OrderController::class);
    Route::resource('/feedstocks'           , \App\Http\Controllers\FeedstockController::class);
    Route::resource('/providers'            , \App\Http\Controllers\ProviderController::class);
    Route::resource('/costs'                , \App\Http\Controllers\CostController::class);
});


