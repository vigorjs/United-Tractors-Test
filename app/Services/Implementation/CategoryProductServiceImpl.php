<?php

namespace App\Services\Implementation;

use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;
use App\Models\CategoryProduct;
use App\Services\CategoryProductService;

class CategoryProductServiceImpl implements CategoryProductService
{
    public function getAllCategories()
    {
        return CategoryProduct::all();
    }

    public function createCategory(StoreCategoryProductRequest $request)
    {
        $data = $request->validated();
        return CategoryProduct::create($data);
    }

    public function getCategoryById(int $id)
    {
        return CategoryProduct::findOrFail($id);
    }

    public function updateCategory($id, UpdateCategoryProductRequest $request)
    {
        $categoryProduct = CategoryProduct::findOrFail($id);

        if(!$categoryProduct) {
            return null;
        }

        $data = $request->validated();
        $categoryProduct->description = $data["description"];
        $categoryProduct->name = $data["name"];
        $categoryProduct->save();

        return $categoryProduct;
    }

    public function deleteCategory(int $id)
    {
        $categoryProduct = CategoryProduct::findOrFail($id);

        $categoryProduct->delete();
    }
}
