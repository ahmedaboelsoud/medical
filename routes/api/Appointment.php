<?php


use App\Http\Controllers\API\AppointmentController;

  // Appointment
  Route::post('appointments/data', [AppointmentController::class,'data'])->name('appointments.data');
  Route::resource('appointments', AppointmentController::class);
  Route::get('appointments/receive_appointments/{id}', [AppointmentController::class,'receive_appointments'])->name('appointments.receive_appointments');
  Route::post('appointments/get_doctor', [AppointmentController::class,'get_doctor'])->name('appointments.get_doctor');


