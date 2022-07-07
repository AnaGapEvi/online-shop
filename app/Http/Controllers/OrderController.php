<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::where('status', '=', 'new')->get();
        return response()->json($orders);
    }
    public function search(Request $request){
//        return response()->json($request->search);
//        $order = Order::where('id', 'LIKE', $request->search.'%')->get();

        $order = Order::where('id', $request->search)->get();

        return response()->json($order);
    }

    public function orders(){
        $orders = Order::get();
        return response()->json($orders);
    }
    public function confirm($id){
        $order =Order::find($id);
        $order->status='confirm';
        $order->save();
        return response()->json($order);
    }

    public function confirmed(){
        $orders = Order::where('status', '=', 'confirmed')->get();
        return response()->json($orders);
    }

    public function userOrders(){
        $orders = Order::where('user_id', '=', Auth::user()->id)->get();
        return response()->json($orders);
    }

    public function cancel($id){
        $order =Order::find($id);
        $order->status='cancelled';
        $order->save();
        return response()->json($order);
    }

    public function cancelled(){
        $orders = Order::where('status', '=', 'cancelled')->get();
        return response()->json($orders);
    }

    public function delivered(){
        $orders = Order::where('status', '=', 'delivered')->get();
        return response()->json($orders);
    }

    public function OrderItem(Request $request, $id){

        $item = Order::find($id);
        if($item){
            return response()->json($item);

        }else{
            $response = ["message" =>'The order number is incorrect'];
            return response($response, 422);
        }
    }

}
