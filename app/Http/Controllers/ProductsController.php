<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::where('quantity', '>', 0)->get();

        return $products;
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        Product::create($data);
    }

    public function update(Product $product, UpdateRequest $request)
    {
        $data = $request->validated();

        $product->update($data);
    }

    public function show(Product $product)
    {
        return $product;
    }

    public function delete(Product $product)
    {
        $product->delete();
    }
}
