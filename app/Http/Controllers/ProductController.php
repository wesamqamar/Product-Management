<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index(Request $request)
    {
        $products = $this->productRepository->getAllProducts($request->only(['name', 'description']));
        return $products->isEmpty()
            ? response()->json(['message' => 'No products found'], 404)
            : ProductResource::collection($products);
    }

    public function show(int $id)
    {
        $product = $this->productRepository->getProductById($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return new ProductResource($product);
    }

    public function store(ProductRequest $request)
    {
        $product = $this->productRepository->createProduct($request->validated());
        return response()->json($product, 201);
    }

    public function update(Request $request, int $id)
    {
        $product = $this->productRepository->updateProduct($id, $request->only(['name', 'description', 'price']));

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json([
            'message' => 'Product updated successfully',
            'product' => $product
        ], 200);
    }

    public function destroy(int $id)
    {
        $deleted = $this->productRepository->deleteProduct($id);

        if (!$deleted) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json(['message' => 'Product deleted successfully'], 200);
    }
}
