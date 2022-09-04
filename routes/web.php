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

Route::get('create-franchise', function (){
    $franchise = new \App\Models\Franchise();
    $franchise->name = 'Adocicare';
    $franchise->save();
    dd($franchise);
});

Route::get('sync-franchise-user', function (){
    $user = \App\Models\User::find(1);
    $franchise = \App\Models\Franchise::find(1);
    $franchise->users()->attach($user);
    dd("ok");
});

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
    Route::resource('/performances'         , \App\Http\Controllers\PerformaceController::class);

    Route::get('/orders/delivered/{orderId}'    , [\App\Http\Controllers\OrderController::class, 'delivered'])->name('orders.delivered');
    Route::get('/orders/paid/{orderId}'         , [\App\Http\Controllers\OrderController::class, 'paid'])->name('orders.paid');

    Route::get('reports'                        , [\App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    Route::get('reports/orders'                 , [\App\Http\Controllers\ReportController::class, 'orders'])->name('reports.orders');
    Route::post('reports/orders'                , [\App\Http\Controllers\ReportController::class, 'orders']);

    Route::get('reports/costs'                  , [\App\Http\Controllers\ReportController::class, 'costs'])->name('reports.costs');
    Route::post('reports/costs'                 , [\App\Http\Controllers\ReportController::class, 'costs']);

});


