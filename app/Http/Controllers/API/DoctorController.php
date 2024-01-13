<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Resources\DoctorResource;
use App\Http\Requests\DoctorRequest;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use App;
use Super;
use File;
use Hash;

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
       $image_path = public_path("assets/doctors/".$doctor->photo);
       if (File::exists($image_path)) {
          File::delete($image_path);
       } 
       $doctor->delete();
       return response()->json('The Doctor successfully deleted');
    }

    public function edite($id)
    {
        $doctor = Doctor::find($id);
        if($doctor){
            return Super::sendResponse(new DoctorResource($doctor));
        }else{
           return Super::sendError('Doctor Not Found', "not found",404); 
        }
        
    }

    public function update(Doctor $doctor,DoctorRequest $request)
    {
        $doctor->update([
            "brief" => $request->brief,
            "birthday" => $request->birthday,
            "status" => $request->status,
        ]);
        $doctor->user->update([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        return Super::sendResponse(trans('site.updated_successfully'));
    }

   public function store(DoctorRequest $request)
    {
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ]);
        $user->doctor()->create([
            "brief" => $request->brief,
            "birthday" => $request->birthday,
            "status" => $request->status,
        ]);
        return Super::sendResponse(trans('site.added_successfully'));
        //return Super::sendError('error validation', $validator->errors(),200);
    }

    public function upload(Request $request){
        $request->validate([
            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
         ]);
 
         if($request->file()) {
            $manager = new ImageManager(new Driver());
            // open an image file
            $image =  $manager->read($request->file);
            // resize image instance
            $image->scale(200, 100);
            // encode edited image
            $encoded = $image->toJpg();
            $newname = time().'.jpg';
            $encoded->save('assets/doctors/'.$newname);
            $doctor = Doctor::whereId($request->id)->first();
            $image_path = public_path("assets/doctors/".$doctor->photo);
            if (File::exists($image_path)) {
               File::delete($image_path);
            }
            $doctor->update(["photo"=>$newname]);
            return Super::sendResponse($doctor->image);
         }

    }
}//end of contro
