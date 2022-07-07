<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::get();
        return response()->json($categories);
    }


//    public function show(Category $category){
//        $category->load('products');
//        return $category;
//    }

    public function categoryProduct($id){
        $products = Product::where('category_id', '=', $id)->get();
        return response()->json($products);
    }
}
