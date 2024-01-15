<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\ManagementRequest;
use App\Http\Resources\ManagementResource;
use Super;
class ManagementController extends Controller
{
    public function __construct()
    {
        // $this->middleware('permission:read_movies')->only(['index']);
        // $this->middleware('permission:create_movies')->only(['create', 'store']);
        // $this->middleware('permission:update_movies')->only(['edit', 'update']);
        // $this->middleware('permission:delete_movies')->only(['delete', 'bulk_delete']);

    }// end of __construct

    public function index(){
      $users = User::whereDoesntHave('doctor')->paginate(3); 
      return ManagementResource::collection($users);
    }// end of index

    public function create(){
        return view('management.create');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManagementRequest $request){
        $user = User::create($request->all()); 
        $user->givePermissionTo($request->userPermission);
        return Super::sendResponse(trans('site.added_successfully'));
    }


    public function destroy($id){   
        $user = User::whereId($id)->first();
        if($user){
            $user->delete();
            return Super::sendResponse(trans('site.deleted_successfully'));
        }else{
           return Super::sendError("User not found",404); 
        }
        
    }// End Of Destroy


    public function edit($id){
        $user = User::whereId($id)->with('permissions')->first();
        if($user){
            return Super::sendResponse($user);
        }else{ return Super::sendError("User not found",404); }
    }

    public function update(ManagementRequest $request, $id){
        $user = User::whereId($id)->first();
        if($user){
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);
            $user->syncPermissions($request->userPermission);
            return Super::sendResponse($request->userPermission);
        }else{ return Super::sendError("User not found",404); }
    }
    
    
    

}//end of contro
