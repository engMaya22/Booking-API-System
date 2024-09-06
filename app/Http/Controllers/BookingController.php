<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreBookingRequest;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends BaseController
{
    public function index(){
        $bookings = Auth::user()->bookings()->with('service')->paginate(10);
        return $this->sendResponse($bookings );
    }
    public function store(StoreBookingRequest $request){
         $validated = $request->validated();
         $validated['user_id'] = Auth::id();
         $booking = Booking::create($validated);
         return $this->sendResponse($booking , 'Booking was created successfuly');

    }

    public function destroy($id){
        $booking = Booking::find($id);
        if($booking)
        {
            $booking->delete();
            return $this->sendResponse([] , 'Booking was deleted successfuly');
        }
        return $this->sendError('Not found this booking',404);


    }
       
}
