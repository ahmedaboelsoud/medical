<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\PatientController;
use App\Http\Controllers\TestController;



// //Route::redirect('/','/en');

// //Route::group(['prefix' => '{lang}'],function (){
//    Route::get('{any}', function () {
//      return view('template.layout');
//    })->where('any', '.*');
// //});
   
      
Route::get('/test',[TestController::class,'index']);




Route::get('/', function () {
    return view('template.layout');
})->middleware('auth');

Route::get('{any?}', function() {
    return view('template.layout');
})->where('any', '.*')->middleware('auth');





