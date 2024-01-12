<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use Spatie\Permission\Models\Role;
use App\Http\Resources\PatientResource;
use App\Http\Requests\PatientRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App;
use Super;

class PatientController extends Controller
{
    
    public function __construct(Request $request)
    {
      
       //$this->middleware('auth:api');

     // $this->middleware('permission:patient')->only(['index']);
     // $this->middleware('permission:patient', ['only' => ['index','show']]);

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
        $patients = Patient::WhenTitle(request()->title)
                           ->WhenMobile(request()->mobile)
                           ->orderby('id','DESC');
        $patients = $patients->paginate(3);
        return PatientResource::collection($patients);
    }

    public function delpatient($id)
    {
       $patient = Patient::find($id);
       $patient->delete();
       return response()->json('The Patient successfully deleted');
    }

    public function edite($id)
    {
        $patient = Patient::find($id);
        if($patient){
            return Super::sendResponse($patient);
        }else{
           return Super::sendError('Patient Not Found', "not found",404); 
        }
        
    }

    public function update($id,PatientRequest $request)
    {
        $patient = Patient::find($id);
        $patient->update($request->all());
        return Super::sendResponse(trans('site.updated_successfully'));
    }

   public function store(PatientRequest $request)
    {
        $patient = Patient::create($request->all());
        return Super::sendResponse(trans('site.added_successfully'));
        //return Super::sendError('error validation', $validator->errors(),200);
    }
}//end of contro
