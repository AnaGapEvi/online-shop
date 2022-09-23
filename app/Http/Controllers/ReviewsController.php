<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Reviews;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewsController extends Controller
{
    public function userReviews(Product $id): JsonResponse
    {
        return response()->json($id->reviews()->with('user')->get());
    }

    public function newReviews(Request $request): JsonResponse
    {
        $product = Product::find($request->product_id);
        $reviews = $product->reviews()->where('user_id', Auth::user()->id)->count();

        if ($reviews) {
            return response()->json(['message' => 'You have already rated this product'], 500);
        }

        $reviews = Reviews::create([
            'stars' => $request->value,
            'comment'=> $request->comment,
            'user_id'=> Auth::user()->id,
            'product_id'=>$request->product_id,
        ]);
        $reviews->save();

        return response()->json($reviews);
    }

    public function update(Request $request,int $id): JsonResponse
    {
        $review = Reviews::find($id);
        $review->update($request->all());
        $review->save();

        return response()->json($review);
    }

    public function destroy(int $id): JsonResponse
    {
        $review = Reviews::find($id);
        $review->delete();

        return response()->json(['massage'=>'review successfully deleted']);
    }
}
