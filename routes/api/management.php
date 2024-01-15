<?php
use App\Http\Controllers\API\ManagementController;


    Route::get('/users', [ManagementController::class, 'index']);
    Route::delete('/delete-user/{id}', [ManagementController::class, 'destroy']);
    Route::get('/edite-user/{id}', [ManagementController::class, 'edit']);
    Route::patch('/update-user/{id}', [ManagementController::class, 'update']);
    Route::post('/add-user', [ManagementController::class, 'store']);






    