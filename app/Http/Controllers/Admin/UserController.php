<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function index(){
        $users = User::paginate(10);
        return $this->sendResponse($users );
    }
    public function show($id){
        $user = User::findOrFail($id);
        return $this->sendResponse($user );

    }
    public function store(StoreUserRequest $request){
         $validated = $request->validated();
         $user = User::create($validated);
         return $this->sendResponse($user , 'User was created successfuly');

    }

    // public function update(StoreBusinessRequest $request , $id){
    //     $business = Business::find($id);
    //     $validated = $request->validated();
    //     if($business){
    //         $business->update($validated);
    //         return $this->sendResponse($business , 'Business was updated successfuly');

    //     }
    //     return $this->sendError('Not found this business');
    // }
    public function destroy($id){
        $user = User::find($id);
        if($user){
            $user->delete();
            return $this->sendResponse([] , 'User was deleted successfuly');
        }
        return $this->sendError('Not found this user',404);

    }
       
}
