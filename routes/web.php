<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;

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


Route::get('reset-password/{token}', [WebController::class, 'resetForm'])->name('reset.password.get');
Route::post('reset-password', [WebController::class, 'reset'])->name('reset.password.post');
Route::get('reset/sukses', [WebController::class, 'sukses'])->name('sukses');

