<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the Product.
     */
    public function index()
    {
        $products = Product::all();
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new Product.
     */
    public function create()
    {
        $products = Product::all();
        return view('products.create', compact('products'));
    }

    /**
     * Store a newly created Product in storage.
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

        return view('products.show', compact('$product'));
    }

    /**
     * Display the specified Product.
     */
    public function show(Product $product)
    {
        Product::findOrFail($product->id);
        if ($product->visibility !== true) {
            return redirect()->route('products.index');
        }
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified Product.
     */
    public function edit(Product $product)
    {
        $products = Product::All();
        return view('products.edit', compact('product', 'products'));
    }

    /**
     * Update the specified Product in storage.
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

        return view('products.edit', compact('product'));
    }

    /**
     * Remove the specified Product from storage.
     */
    public function destroy(Product $product)
    {
        Product::findOrFail($product->id)->delete();
        return redirect()->route('products.index');
    }
}
