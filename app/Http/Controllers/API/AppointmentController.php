<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Profit;
use App\Http\Resources\PatientResource;
use App\Http\Resources\DoctorResource;
use App\Http\Resources\AppointmentResource;
use App\Http\Requests\AppointmentRequest;
use Super;

class AppointmentController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:read_movies')->only(['index']);
        // $this->middleware('permission:create_movies')->only(['create', 'store']);
        // $this->middleware('permission:update_movies')->only(['edit', 'update']);
        // $this->middleware('permission:delete_movies')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index(){
      $patients = Patient::get();  
      $doctors = Doctor::get();  
      //return $this->sendError('Bad Request', '(Un Expected Values)',000);
      $res = [
        'patients' => PatientResource::collection($patients),
        'doctors'  => DoctorResource::collection($doctors),
      ];
      return Super::sendResponse($res);
    }// end of index

    public function data()
    {
        $appointments = Appointment::WhenDoctorId(request()->doctor)
                                    ->WhenPatientId(request()->patient)
                                    ->WhenStartdate(request()->startdate)
                                    ->WhenEnddate(request()->enddate)
                                    ->orderby('id','DESC');
        $appointments = $appointments->paginate(3);
        return AppointmentResource::collection($appointments);
    }// end of data

   
    public function receive_appointments($p_id){
        $patient = Patient::where('id',$p_id)->first();
        if($patient){
            $doctors = Doctor::whereStatus('active')->get();  
            return view('appointment.receive',compact('doctors'));
        }else{return redirect('404');}
    }

    public function get_doctor(Request $q){
        $appointment = Appointment::where('doctor_id',$q->doctor_id)
                                  ->where('appdata',$q->appdata)
                                  ->with('patients')->get();              
        return Super::sendResponse(AppointmentResource::collection($appointment));
    }

    public function store(AppointmentRequest $request){
        $chckApp = Appointment::where('doctor_id',$request->doctor_id)
                               ->where('patient_id',$request->patient_id)
                               ->where('appdata',$request->appdata)
                               ->count();
        if($chckApp >= 1){
            return Super::sendError("exist",404); 
        }else{
            $appointment = Appointment::create([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
                'appdata' => $request->appdata,
            ]);
            if($request->price){
                $appointment->profits()->create(['price'=>$request->price]);
            }
            return Super::sendResponse('added_successfully');
        }                            
       
    }


    
  
   

   
    

}//end of contro
