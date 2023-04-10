<?php

use App\Http\Controllers\IndicadoresController;
use App\Http\Controllers\chartController;
use Illuminate\Support\Facades\Route;

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


// Esta ruta responde a una solicitud GET en la raíz y devuelve la vista "home"
Route::get('/', function () {
    return view('home');
});

//llama al método "token_generator" del controlador
Route::get('token_generator', [IndicadoresController::class, 'token_generator']);

//llama al método "extract_uf" del controlador 
Route::get('extract_uf', [IndicadoresController::class, 'extract_uf']);

//Esta ruta llama al método "fill_DB" del controlador
Route::get('fill_DB', [IndicadoresController::class, 'fill_DB']);

//define una ruta que permite realizar operaciones CRUD en el controlador
Route::resource('crud', IndicadoresController::class);

// llama al método "get_data" del controlador
Route::get('chart', [chartController::class, 'get_data']);
