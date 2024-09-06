<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Business;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends BaseController
{
    public function getReviews($id){
        $reviews = Business::find($id)->reviews()->paginate(10);
        return $this->sendResponse($reviews );
    }
    public function show($id){
        $business = Review::findOrFail($id);
        return $this->sendResponse($business );

    }
    public function store(StoreReviewRequest $request){
         $validated = $request->validated();
         $validated['user_id'] = Auth::id();
         $review = Review::create($validated);
         return $this->sendResponse($review , 'Review was created successfuly');

    }
    public function update(StoreReviewRequest $request , $id){
        $review = Review::find($id);
        $validated = $request->validated();
        if($review){
            $review->update($validated);
            return $this->sendResponse($review , 'Review was updated successfuly');

        }
        return $this->sendError('Not found this Review');
    }

    public function destroy($id){
        $review = Review::find($id);
        if($review)
        {
            $review->delete();
            return $this->sendResponse([] , 'Review was deleted successfuly');
        }
        return $this->sendError('Not found this Review',404);


    }
       
}
