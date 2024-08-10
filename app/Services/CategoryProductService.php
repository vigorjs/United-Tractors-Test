<?php

namespace App\Services;

use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;

interface CategoryProductService
{
    public function getAllCategories();
    public function createCategory(StoreCategoryProductRequest $request);
    public function getCategoryById(int $id);
    public function updateCategory(int $id, UpdateCategoryProductRequest $request);
    public function deleteCategory(int $id);
}
