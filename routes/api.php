<?php

use Illuminate\Http\Request;
use App\helper\RouteHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\DashboardController;


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


Route::get('dashboard', [DashboardController::class, 'index']);

Route::post('register', [RegisterController::class, 'register']);
Route::post('login', [RegisterController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cahngelanf',function(Request $request){
  App::setLocale('ar');
  $res  = App::getLocale();
  return response()->json(['message'=> __('site.deleted_successfully')]);
});


RouteHelper::includeRouteFiles(__DIR__.'/api');



