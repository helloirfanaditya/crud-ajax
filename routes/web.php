<?php

use App\Http\Controllers\UserController;
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

Route::get('/', [UserController::class, 'index']);
Route::post('/', [UserController::class, 'store']);
Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
