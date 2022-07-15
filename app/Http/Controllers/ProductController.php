<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Nette\Utils\Image;
use Symfony\Component\Console\Input\Input;

//use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        return Product::with('categories')->get();
        $products =  Product::orderBy('id', 'asc')->get();
        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $product =  Product::find($id);
        return response()->json($product);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        if($request->hasfile('image'))
        {
        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension(); // getting image extension
        $filename =time().'.'.$extension;
        $image= $file->move('uploads/images/', $filename);
    }
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->category_id =$request->category_id;
        $product->image=$image;
        $product->save();

        return response()->json($product);
    }
    public function like(Request $request, $id)
    {
//        $product = Product::find($request->id);
//        $reviews = $product->likes()->where('user_id', Auth::user()->id )->count();
//
//        if(!$reviews){
            $data = Product::find($id);
            $data->likes = $data->likes+=1;
            $data->save();
            return response()->json($data);
//        }
    }
//    public function searchProduct(Request $request)
//    {
//        $data = Product::where('name', 'LIKE', $request->keyword.'%')->get();
//        return response()->json($data);
//    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product, $id)
    {
        $product = Product::find($id);
        $product->update($request->all());

        return response()->json($product);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, $id)
    {

        $product = Product::find($id);
        $currentPhoto = $product->image;
        $productPhoto = public_path('storage').$currentPhoto;
        if(file_exists($productPhoto)) {
            @unlink($productPhoto);
        }
        $product->delete();

        return response()->json('Product deleted!');
    }

}
