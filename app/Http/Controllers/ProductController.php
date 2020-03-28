<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function index()
    {
        $per_page = request()->get('per_page') ?: 10;

        $products = Product::filter(new ProductFilter());

        if (! request('sort')) {
            $products->orderBy('id');
        }

        $products = $products->paginate($per_page);

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $product = Product::create($request->toArray());

        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $updated = $product->update($request->toArray());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $deleted = $product->delete();

        return response([], 200);
    }
}
