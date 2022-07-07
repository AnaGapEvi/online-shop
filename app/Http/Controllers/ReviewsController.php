<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewsRequest;
use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function userReviews($id){
//        if (Auth::check()) {
            $reviews= Reviews::where('product_id',  '=', $id)->get();
            return response()->json($reviews);
//        }

    }

    public function newReviews(Request $request){


        $product = Product::find($request->product_id);
        $reviews = $product->reviews()->where('user_id', Auth::user()->id )->count();
//            Reviews::where('product_id', $request->product_id AND 'user_id', '=', Auth::user()->id)->get();


        if(!$reviews){

            $reviews = Reviews::create([
                'stars' => $request->value,
                'comment'=> $request->comment,
                'user_id'=> Auth::user()->id,
                'product_id'=>$request->product_id,
            ]);
            $reviews->save();

            return response()->json($reviews);
        } else {
            return response()->json(['message'=>'You have already rated this product'], 500);
        }




    }
    public function update(Request $request, $id)
    {
        $review = Product::find($id);
        $review->update($request->all());

        return response()->json($review);

    }

    public function destroy($id){
        $review = Reviews::find($id);
        $review->delete();
        return response()->json(['massage'=>'review successfully deleted']);

    }

    public function allReviews($id){
        $reviews = Reviews::where('product_id',  '=', $id);
        return response()->json($reviews);
    }
}
