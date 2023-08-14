<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function ($router) {
  Route::post('register', [AuthController::class, 'register']);
  Route::post('forget', [AuthController::class, 'forget']);
  Route::post('login', [AuthController::class, 'login']);
  Route::post('logout', [AuthController::class, 'logout']);
  Route::post('refresh', [AuthController::class, 'refresh']);
  Route::get('me', [AuthController::class, 'me']);
});

Route::middleware(['jwt.verify'])->group(function () {
  Route::get('/users', [UserController::class, 'read']);
  Route::post('/users', [UserController::class, 'create']);
  Route::post('/users/{id}', [UserController::class, 'update']);
  Route::delete('/users/{id}', [UserController::class, 'delete']);
  Route::get('/user/search', [UserController::class, 'search']);
  Route::get('/user/paginate', [UserController::class, 'paginate']);

  Route::post('/account', [AccountController::class, 'update']);
  Route::put('/account/password', [AccountController::class, 'password_change']);
});





// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
