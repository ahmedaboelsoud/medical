<?php
use App\Http\Controllers\API\DoctorController;


Route::post('/test', [DoctorController::class, 'test']);
    Route::post('/doctors', [DoctorController::class, 'index']);
    Route::delete('/delete-doctor/{id}', [DoctorController::class, 'deldoctor']);
    Route::get('/edite-doctor/{id}', [DoctorController::class, 'edite']);
    Route::patch('/update-doctor/{doctor}', [DoctorController::class, 'update']);
    Route::post('/add-doctor', [DoctorController::class, 'store']);
    Route::post('/upload-doctor', [DoctorController::class, 'upload']);






    