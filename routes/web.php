<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\ProductosController;

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

Route::get('/',[LoginController::class, 'index'])->name('login');
Route::get('/login',[LoginController::class, 'index'])->name('login');
Route::post('/login',[LoginController::class, 'store']);
Route::get('/logout',[LogoutController::class, 'store'])->name('logout');

Route::get('/productos',[ProductosController::class, 'index'])->name('productos.index');
Route::post('/productos',[ProductosController::class, 'store'])->name('productos.store');
Route::post('/productos/{idProducto}',[ProductosController::class, 'update'])->name('productos.update');
Route::get('/updateCantidad/{cantidad}/{idProducto}',[ProductosController::class, 'updateCantidad'])->name('updateCantidad.updateCantidad');
Route::delete('/productos/{idProducto}',[ProductosController::class, 'destroy'])->name('productos.destroy');
Route::delete('/eliminarCategoria/{idCategoria}/{idProducto}',[ProductosController::class, 'deleteCat'])->name('productos.deleteCat');
