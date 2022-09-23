<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::get();

        return response()->json($categories);
    }

    public function categoryProduct(int $id): JsonResponse
    {
        $products = Product::where('category_id', '=', $id)->get();

        return response()->json($products);
    }
}
