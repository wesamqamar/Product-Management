<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(array $filters = [], int $perPage = 10)
    {
        return Product::query()
            ->filter($filters) // Call the filter scope
            ->paginate($perPage);
    }
    public function getProductById(int $id)
    {
        return Product::find($id);
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(int $id, array $data)
    {
        $product = Product::find($id);

        if ($product) {
            $product->update($data);
            return $product;
        }

        return null;
    }

    public function deleteProduct(int $id)
    {
        $product = Product::find($id);

        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }
}
