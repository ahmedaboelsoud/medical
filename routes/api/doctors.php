<?php
use App\Http\Controllers\API\DoctorController;


Route::post('/test', [DoctorController::class, 'test']);
    Route::post('/doctors', [DoctorController::class, 'index']);
    Route::delete('/delete-doctors/{id}', [DoctorController::class, 'delpatient']);
    Route::get('/edite-doctor/{id}', [DoctorController::class, 'edite']);
    Route::patch('/update-doctor/{id}', [DoctorController::class, 'update']);
    Route::post('/add-doctor', [DoctorController::class, 'store']);





    