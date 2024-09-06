<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBusinessRequest;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends BaseController
{
    public function index(){
        $business = Business::paginate(10);
        return $this->sendResponse($business );
    }
    public function show($id){
        $business = Business::findOrFail($id);
        return $this->sendResponse($business );

    }
    public function store(StoreBusinessRequest $request){
         $validated = $request->validated();
         $business = Business::create($validated);
         return $this->sendResponse($business , 'Business was created successfuly');

    }
    public function update(StoreBusinessRequest $request , $id){
        $business = Business::find($id);
        $validated = $request->validated();
        if($business){
            $business->update($validated);
            return $this->sendResponse($business , 'Business was updated successfuly');

        }
        return $this->sendError('Not found this business');
    }
    public function destroy($id){
        $business = Business::find($id);
        if($business)
        {
            $business->delete();
            return $this->sendResponse([] , 'Business was deleted successfuly');
        }
        return $this->sendError('Not found this business',404);


    }
       
}
