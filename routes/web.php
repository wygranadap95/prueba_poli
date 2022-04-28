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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

/*Autores*/
Route::resource('autores', App\Http\Controllers\AutoresController::class)->middleware('auth');
Route::post('autores/guardar', [App\Http\Controllers\AutoresController::class, 'guardar']);
Route::post('autores/delete', [App\Http\Controllers\AutoresController::class, 'delete']);
Route::post('autores/update', [App\Http\Controllers\AutoresController::class, 'update']);

/*Libros*/
Route::resource('libros', App\Http\Controllers\LibrosController::class)->middleware('auth');
Route::post('libros/guardar', [App\Http\Controllers\LibrosController::class, 'guardar']);
Route::post('libros/delete', [App\Http\Controllers\LibrosController::class, 'delete']);
Route::post('libros/update', [App\Http\Controllers\LibrosController::class, 'update']);
