<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function index(): JsonResponse
    {
        $products = Product::orderBy('id', 'asc')->get();

        return response()->json($products);
    }

    public function create(int $id): JsonResponse
    {
        $product =  Product::find($id);

        return response()->json($product);
    }

    public function store(Request $request, Product $product): JsonResponse
    {
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $filename =time().'.'.$extension;
            $image= $file->move('uploads/images/', $filename);
        }

        $validator = $request->validate([
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
            'quantity'=>'required|min:1',
            'category_id'=>'required',
        ]);

        if (!$validator) return  response()->json($validator->error());

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id =$request->category_id;
        $product->image=$image;
        $product->save();

        return response()->json($product);
    }

    public function like(int $id): JsonResponse
    {
        $data = Product::find($id);
        $data->likes = $data->likes+=1;
        $data->save();

        return response()->json($data);
    }

    public function disLike(int $id): JsonResponse
    {
        $data = Product::find($id);
        $data->likes = $data->likes-=1;
        $data->save();

        return response()->json($data);
    }

    public function show(int $id): JsonResponse
    {
        $product = Product::find($id);

        return response()->json($product);
    }

    public function update(Request $request,int $id): JsonResponse
    {
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json($product);
    }

    public function destroy(int  $id): JsonResponse
    {
        $product = Product::find($id);
        $currentPhoto = $product->image;
        $productPhoto = public_path('storage').$currentPhoto;
        if (file_exists($productPhoto)) {
            @unlink($productPhoto);
        }
        $product->delete();

        return response()->json('Product deleted!');
    }
}
