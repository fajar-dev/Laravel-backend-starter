<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PMIController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BdrsController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\RequestsController;
use App\Http\Controllers\NotificationController;

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

Route::put('/account/update/{id}', [AccountController::class, 'update'])->middleware('jwt.verify');
Route::post('/account/photo/{id}', [AccountController::class, 'photo'])->middleware('jwt.verify');




// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
