<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Auth;
class WishListController extends Controller
{
    public function wishList(){

        $list = WishList::query()->where('user_id',  '=', Auth::user()->id)->get();
        return response()->json($list);
    }

    public function allWishList(){
        $list = WishList::get();
        return response($list);
    }
}
