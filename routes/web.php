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
    $order = \App\Models\Order::first();
    $ontem = today()->subDays(1);
    $hoje = today();
    $dif = $hoje->diffInDays($ontem);

    dd($hoje < $ontem, $dif);
    $order = \App\Models\Order::find(20);
    $data = $order->delivery_date;
    $hoje = today();
    $dif = $hoje->diffInDays($data);
    dd($hoje >= $data, $dif);
    $numero = 1500;
    dd(\App\Helpers\showCentsValue($numero));
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware('auth')->group(function (){
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('/products', \App\Http\Controllers\ProductController::class);
    Route::resource('/customers', \App\Http\Controllers\CustomerController::class);
    Route::resource('/aditionals', \App\Http\Controllers\AditionalController::class);
    Route::resource('/orders', \App\Http\Controllers\OrderController::class);
});


