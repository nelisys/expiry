<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Product;
use App\Http\Filters\ProductFilter;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;

class ProductController extends Controller
{
    public function summary()
    {
        $products_expired = Product::where('user_id', auth()->user()->id)
            ->whereDate('expiry_date', '<', Carbon::today())->count();

        $products_today = Product::where('user_id', auth()->user()->id)
            ->whereDate('expiry_date', Carbon::today())->count();

        $products_future = Product::where('user_id', auth()->user()->id)
            ->whereDate('expiry_date', '>', Carbon::today())->count();

        return [
            'expired' => $products_expired,
            'today' => $products_today,
            'future' => $products_future,
        ];
    }

    public function index()
    {
        $per_page = request()->get('per_page') ?: 10;

        $products = Product::where('user_id', auth()->user()->id)
            ->filter(new ProductFilter());

        if (! request('sort')) {
            $products->orderBy('id');
        }

        $products = $products->paginate($per_page);

        return ProductResource::collection($products);
    }

    public function show(Product $product)
    {
        $this->authorize('access', $product);

        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $data = $request->toArray();
        $data['user_id'] = auth()->user()->id;

        $product = Product::create($data);

        return new ProductResource($product);
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize('access', $product);

        $updated = $product->update($request->toArray());

        return new ProductResource($product);
    }

    public function destroy(Product $product)
    {
        $this->authorize('access', $product);

        $deleted = $product->delete();

        return response([], 200);
    }
}
