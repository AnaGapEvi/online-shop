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
//        if($request->product_id)
            $bag = Bag::create([
                'product_id'=>$request->product_id,
                'user_id'=> Auth::user()->id,
                'quantity'=>$request->quantity
            ]);
            $bag->save();
            return response()->json($bag);
    }
    public function incrementQuantity(Request $request, $id){
        $product = Bag::find($id);
        $product->quantity=$product->quantity+=1;
        $product->save();
        return response()->json($product);
    }

    public function decrementQuantity(Request $request, $id){
        $product = Bag::find($id);
        if($product->quantity > 1){
            $product->quantity=$product->quantity-=1;
            $product->save();
            return response()->json($product);

        }else {
            return response()->json($product);
        }

    }

    public function destroy($id){
        $product = Bag::find($id);
        $product->delete();
        return response()->json(['massage'=>'product successfully deleted']);
    }
}
