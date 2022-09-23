<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(): JsonResponse
    {
        $orders = Order::where('status', '=', 'new')->get();

        return response()->json($orders);
    }

    public function search(Request $request): JsonResponse
    {

        $order = Order::where('id', $request->search)->get();

        return response()->json($order);
    }

    public function orders(): JsonResponse
    {
        $orders = Order::get();

        return response()->json($orders);
    }

    public function confirm(int $id): JsonResponse
    {
        $order =Order::find($id);
        $order->status='confirm';
        $order->save();

        return response()->json($order);
    }

    public function confirmed(): JsonResponse
    {
        $orders = Order::where('status', '=', 'confirmed')->get();

        return response()->json($orders);
    }

    public function userOrders(): JsonResponse
    {
        $orders = Order::where('user_id', '=', Auth::user()->id)->get();

        return response()->json($orders);
    }

    public function cancel(int $id): JsonResponse
    {
        $order =Order::find($id);
        $order->status='cancelled';
        $order->save();

        return response()->json($order);
    }

    public function cancelled(): JsonResponse
    {
        $orders = Order::where('status', '=', 'cancelled')->get();

        return response()->json($orders);
    }

    public function delivered(): JsonResponse
    {
        $orders = Order::where('status', '=', 'delivered')->get();

        return response()->json($orders);
    }

    public function OrderItem(int $id): JsonResponse
    {
        $item = Order::find($id);
        if ($item) {
            return response()->json($item);
        } else {
            return response()->json(["message" =>'The order number is incorrect'],  422);
        }
    }

}
