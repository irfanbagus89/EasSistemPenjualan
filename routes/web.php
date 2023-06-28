<?php

use App\Http\Controllers\DetailpenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenDetailController;
use App\Http\Controllers\PenjualanController;


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
// Obat
Route::get('/',[ObatController::class, 'home']);
Route::get('/obat',[ObatController::class, 'index']);
Route::post('/createObat',[ObatController::class, 'create']);
Route::get('/editObat/{id_obat}',[ObatController::class, 'updatePage']);
Route::post('/updateObat',[ObatController::class, 'update']);
Route::get('/deleteObat/{id_obat}',[ObatController::class, 'deleteObat']);


// Penjualan
Route::get('/penjualan',[PenjualanController::class, 'index']);
Route::get('/addCart/{id_obat}',[PenjualanController::class, 'addCart']);
Route::post('/bayar',[PenjualanController::class, 'bayar']);
Route::get('/cart/hapus/{id}', [PenjualanController::class, 'hapusBarang']);


Route::get('/history',[PenjualanController::class, 'history']);