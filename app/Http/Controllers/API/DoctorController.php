<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use Spatie\Permission\Models\Role;
use App\Http\Resources\DoctorResource;
use App\Http\Requests\DoctorRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App;
use Super;

class DoctorController extends Controller
{
    
    public function __construct(Request $request)
    {
      
       //$this->middleware('auth:api');

     // $this->middleware('permission:doctor')->only(['index']);
     // $this->middleware('permission:doctor', ['only' => ['index','show']]);

      //$this->middleware('permission:product-create', ['only' => ['create','store']]);
      //    $this->middleware('permission:product-edit', ['only' => ['edit','update']]);
      //    $this->middleware('permission:product-delete', ['only' => ['destroy']]);


       if (!isset($request->lang)) {
        $request->lang = "en";
       }
       if ($request->lang != "ar" && $request->lang != "en") {
          $request->lang = "en";
          return $this->sendError('Bad Request', '(Un Expected Values)',503);
          ///return false;
         }
         App::setLocale($request->lang);
        }

    public function test()
    {
        return view('test');

    }
    public function index()
    {
        $doctors = Doctor::WhenName(request()->name)
                           ->WhenStatus(request()->status)
                           ->orderby('id','DESC');
        $doctors = $doctors->paginate(3);
        return DoctorResource::collection($doctors);
    }

    public function deldoctor($id)
    {
       $doctor = Doctor::find($id);
       $doctor->delete();
       return response()->json('The Doctor successfully deleted');
    }

    public function edite($id)
    {
        $doctor = Doctor::find($id);
        if($doctor){
            return Super::sendResponse($doctor);
        }else{
           return Super::sendError('Doctor Not Found', "not found",404); 
        }
        
    }

    public function update($id,DoctorRequest $request)
    {
        $doctor = Doctor::find($id);
        $doctor->update($request->all());
        return Super::sendResponse(trans('site.updated_successfully'));
    }

   public function store(DoctorRequest $request)
    {
        $doctor = Doctor::create($request->all());
        return Super::sendResponse(trans('site.added_successfully'));
        //return Super::sendError('error validation', $validator->errors(),200);
    }
}//end of contro
