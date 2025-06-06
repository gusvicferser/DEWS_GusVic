<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        foreach ($products as $key => $product) {
            if ($key === 'prod_img') {
                $products->$key = asset($product);
            }
        }
        return response()->json($products, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product = new Product();
        $fileName = $request->get('prod_img') . '.jpg';
        $product->prod_name = $request->get('prod_name');
        $product->slug = Str::slug($product->prod_name);
        $product->prod_desc = $request->get('prod_desc');
        $request->file('prod_img')->storeAs('products', $fileName);
        $product->prod_img = 'storage/products/' . $fileName;
        $product->prod_stock = $request->get('prod_stock');
        $product->prod_price = $request->get('prod_price');

        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product->prod_img = asset($product->prod_img);
        return response()->json($product, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $fileName = $request->get('prod_img') . '.jpg';
        $product->prod_name = $request->get('prod_name');
        $product->slug = Str::slug($product->prod_name);
        $product->prod_desc = $request->get('prod_desc');
        $request->file('prod_img')->storeAs('products', $fileName);
        $product->prod_img = 'storage/products/' . $fileName;
        $product->prod_stock = $request->get('prod_stock');
        $product->prod_price = $request->get('prod_price');

        $product->save();

        return response()->json($product, 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json($product, 204);
    }
}
