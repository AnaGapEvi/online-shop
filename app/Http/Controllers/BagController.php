<?php

namespace App\Http\Controllers;

use App\Models\Bag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BagController extends Controller
{
    public function index(){
        $prod = Auth::user()->products;
        return response()->json($prod);
    }

    public function  addToBag(Request $request){
            $bag = Bag::create([
                'product_id'=>$request->product_id,
                'user_id'=> Auth::user()->id,
                'quantity'=>$request->quantity
            ]);
            $bag->save();
            return response()->json($bag);
    }

    public function destroy($id){
        $product = Bag::find($id);
        $product->delete();
        return response()->json(['massage'=>'product successfully deleted']);

    }
}
