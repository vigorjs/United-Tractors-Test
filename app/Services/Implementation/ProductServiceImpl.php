<?php

namespace App\Services\Implementation;

use Illuminate\Support\Str;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\CategoryProductService;
use App\Services\ProductService;

class ProductServiceImpl implements ProductService{

    protected $categoryProductService;

    public function __construct(CategoryProductService $categoryProductService)
    {
        $this->categoryProductService = $categoryProductService;
    }

    public function getAllProducts(){
        return Product::all();
    }

    public function createProduct(StoreProductRequest $request){
        $data = $request->validated();
        //cek category
        if($request->product_category_id) {
            $category = $this->categoryProductService->getCategoryById($request->product_category_id);
            if (!$category) {
                throw new \Exception('Category not found');
            }
        }

        //handling image upload
        if($request->hasFile("image")) {
            $file = $request->file("image");
            $extention = $file->getClientOriginalExtension();
            $fileName = Str::slug($request->name) . "-" . time() . "." . $extention;
            $path = $file->storeAs("public/products", $fileName);
            $data["image"] = $path;
        }

        return Product::create($data);
    }

    public function getProductById(int $id){
        return Product::findOrFail($id);
    }

    public function updateProduct(int $id, UpdateProductRequest $request){
        //get product
        $product = $this->getProductById($id);

        // validasi request
        $data = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $fileName = Str::slug($data['name'] ?? $product->name) . '-' . time() . '.' . $extension;
            $path = $file->storeAs('public/products', $fileName);
            $data['image'] = $path;
        }

        $product->update($data);
        return $product;
    }

    public function deleteProduct(int $id){
        $product = Product::findOrFail($id);

        $product->delete();
    }

}
