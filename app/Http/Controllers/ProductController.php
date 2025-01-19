<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function store(ProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }

    public function index(Request $request)
    {
        $products = Product::filter($request->only(['name', 'description']))
                           ->paginate();

        return $products->isEmpty()
            ? response()->json(['message' => 'No products found'], 404)
            : response()->json($products);
    }
    public function show(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
    public function update(Request $request, int $id)
    {
        $validate = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric',
        ]);
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->update($validate);
        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);
    }


    public function destroy(int $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->delete();
        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
