<?php

namespace App\Http\Controllers;

use App\Models\Shopping_address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingAddressController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $address = new Shopping_address();
        $address->user_id = Auth::user()->id;
        $address->address = $request->address;
        $address->city = $request->city;
        $address->country = $request->country;
        $address->zip = $request->zip;
        $address->telephone = $request->telephone;
        $address->save();

        return response()->json($address);
    }
}
