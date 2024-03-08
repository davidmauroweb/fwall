<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{FwallController};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('home');
});
Auth::routes();
Auth::routes(['register' => false]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/graph/{us}', [App\Http\Controllers\HomeController::class, 'show'])->name('home.show');
//rutas admin
Route::group(['middleware' => 'admin'], function () {
    Route::get('/lista', [App\Http\Controllers\FwallController::class, 'index'])->name('lista.index');
    Route::get('/formulario', function () {
        return view('nuevo-us');
    })->name('formulario');
    Route::post('/lista', [App\Http\Controllers\FwallController::class, 'store'])->name('lista.store');
    Route::post('/lista-del', [App\Http\Controllers\FwallController::class, 'del'])->name('lista.del');
    Route::post('/graph', [App\Http\Controllers\HomeController::class, 'show2'])->name('home.show2');
});
