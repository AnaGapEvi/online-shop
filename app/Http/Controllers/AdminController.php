<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct(){
//        $this->middleware('admin');

    }

    public function index(){
        $users = User::get();
        return response()->json($users);
    }


    public function reports(Request $request){

        $start_date = Carbon::parse($request->start);


        $end_date = Carbon::parse($request->end);


        $orders = Order::whereBetween('created_at', [
            $start_date, $end_date
        ])->get();

        return response()->json($orders);

//        Log::info(print_r($orders, true ) );
    }
}
