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
        $title = (isset(\request()->title) && \request()->title != '') ? \request()->title : null ;
        
        $mobile  = (isset(\request()->mobile ) && \request()->mobile  != '') ? \request()->mobile  : null ;
        
        //$cat = (isset(\request()->cat) && \request()->cat != '') ? \request()->cat : null ;

        $patients = Patient::query();

        if($title != null){
            $patients->where('title', 'LIKE', "%{$title}%");
        }
        if($mobile != null){
            $patients->where('mobile', 'LIKE', "%{$mobile}%");
        }
       // $books =  BookResource::collection($books->with('Category')->paginate());
        $patients = $patients->paginate(3);
        return PatientResource::collection($patients);

       //$books = $books->with('Category')->paginate(3);
         $response = [
            'success' => true ,
            'data' => $patients,
            
        ];
        return response()->json($response , 200);
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
        $response = [
            'success' => true ,
            'data' => $patient,
        ];
        return response()->json($response , 200);
    }

    // update book
    public function update($id,PatientRequest $request)
    {
        $patient = Patient::find($id);
        $patient->update($request->all());

        return response()->json('The book successfully updated');
    }

   public function store(PatientRequest $request)
    {
        $patient = Patient::create([
            'title' => $request->title,
            'email' => $request->email,
            'mobile' => $request->mobile,
            'job' => $request->job,
            'birthday' => $request->birthday,
            'adress' => $request->adress,
            'gender' => $request->gender,
            'height' => $request->height,
            'weight' => $request->weight,
        ]);
        return response()->json('The Patient successfully Added');
        // return response()->json(App::getLocale());
    }
}//end of contro
