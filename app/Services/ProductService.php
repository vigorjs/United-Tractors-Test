<?php

namespace App\Services;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;

interface ProductService
{
    public function getAllProducts();
    public function createProduct(StoreProductRequest $request);
    public function getProductById(int $id);
    public function updateProduct(int $id, UpdateProductRequest $request);
    public function deleteProduct(int $id);
}
