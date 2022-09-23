<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function index(): JsonResponse
    {
        $users = User::get();
        return response()->json($users);
    }


    public function reports(Request $request): JsonResponse
    {
        $start_date = Carbon::parse($request->start);
        $end_date = Carbon::parse($request->end);
        $orders = Order::whereBetween('created_at', [$start_date, $end_date])->get();

        return response()->json($orders);
    }
}
