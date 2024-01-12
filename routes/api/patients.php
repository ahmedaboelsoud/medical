<?php
use App\Http\Controllers\API\PatientController;


Route::post('/test', [PatientController::class, 'test']);
    Route::post('/patients', [PatientController::class, 'index']);
    Route::delete('/delete-patients/{id}', [PatientController::class, 'delpatient']);
    Route::get('/edite-patient/{id}', [PatientController::class, 'edite']);
    Route::patch('/update-patient/{id}', [PatientController::class, 'update']);
    Route::post('/add-patient', [PatientController::class, 'store']);





    