<?php

namespace App\Http\Controllers\Business;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreServiceRequest;
use App\Models\Business;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends BaseController
{
    public $authId;
    public $business;
    public function __construct()
    {
        $this->authId = Auth::id();
        $this->business = Business::where('user_id',$this->authId)->first();
    }
    public function index(){
      
        if($this->business)
          {
            $services = $this->business->services()->paginate(10);
            return $this->sendResponse($services );
          }
        return $this->sendError('there is no service');


    }
    public function store(StoreServiceRequest $request){
        $validated = $request->validated();
        $validated['business_id'] = $this->business->id;
        $service = Service::create($validated);
        return $this->sendResponse($service , 'Service was created successfuly');

   }
  
   public function update(StoreServiceRequest $request , $id){
    $service = Service::find($id);
    $validated = $request->validated();
    if($service){
        $service->update($validated);
        return $this->sendResponse($service , 'Service was updated successfuly');

    }
     return $this->sendError('Not found this Service');
    }
    public function destroy($id){
        $service = Service::find($id);
        if($service)
        {
            $service->delete();
            return $this->sendResponse([] , 'Service was deleted successfuly');
        }
        return $this->sendError('Not found this Service',404);
    
       }

}
