<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *     schema="Product",
 *     type="object",
 *     title="Product",
 *     required={"id", "name", "price"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Lampu"),
 *     @OA\Property(property="price", type="integer", example="10000"),
 *     @OA\Property(property="image", type="file"),
 *     @OA\Property(property="product_category_id", type="integer", example="1"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="StoreProductRequest",
 *     type="object",
 *     title="Store Product Request",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Electronics"),
 *     @OA\Property(property="price", type="integer", example="10000"),
 *     @OA\Property(property="image", type="file"),
 *     @OA\Property(property="product_category_id", type="integer", example="1")
 * )
 *
 * @OA\Schema(
 *     schema="UpdateProductRequest",
 *     type="object",
 *     title="Update Product Request",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Updated Electronics"),
 *     @OA\Property(property="price", type="integer", example="10000"),
 *     @OA\Property(property="image", type="file"),
 *     @OA\Property(property="product_category_id", type="integer", example="1")
 * )
 */
class ProductController extends Controller
{

    protected $productService;

    public function __construct(ProductService $productService){
        $this->productService = $productService;
    }

    /**
     * @OA\Get(
     *     path="/products",
     *     tags={"Product"},
     *     operationId="getProducts",
     *     summary="Get list of all Products",
     *     description="Returns list of all Products",
     *     @OA\Response(
     *         response=200,
     *         description="Success get all Products",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/Product")
     *         )
     *     )
     * )
     */
    public function index(){
        return response()->json($this->productService->getAllProducts());
    }

    /**
     * @OA\Post(
     *     path="/products",
     *     tags={"Product"},
     *     operationId="storeProduct",
     *     summary="Create new Product",
     *     description="Creates a new Product",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name"},
     *                 @OA\Property(property="name", type="string", example="Electronics"),
     *                 @OA\Property(property="price", type="integer", example="10000"),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="product_category_id", type="integer", example="1")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Product Created",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function store(StoreProductRequest $request){
        return response()->json($this->productService->createProduct($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/products/{id}",
     *     tags={"Product"},
     *     operationId="getProductById",
     *     summary="Get Product by ID",
     *     description="Returns a single Product",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful Operation",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     )
     * )
     */
    public function show($id){
        try {
            return response()->json($this->productService->getProductById($id));
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Post(
     *     path="/products/{id}",
     *     tags={"Product"},
     *     operationId="updateProduct",
     *     summary="Update an existing Product",
     *     description="Updates a Product's information",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"name"},
     *                 @OA\Property(property="name", type="string", example="Electronics"),
     *                 @OA\Property(property="price", type="integer", example="10000"),
     *                 @OA\Property(property="image", type="string", format="binary"),
     *                 @OA\Property(property="product_category_id", type="integer", example="1")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Product Updated",
     *         @OA\JsonContent(ref="#/components/schemas/Product")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Product not found")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation Error",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="The given data was invalid."),
     *             @OA\Property(property="errors", type="object")
     *         )
     *     )
     * )
     */
    public function update(UpdateProductRequest $request, $id){
        try {
            return response()->json($this->productService->updateProduct($id, $request));
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Delete(
     *     path="/products/{id}",
     *     tags={"Product"},
     *     operationId="deleteProduct",
     *     summary="Delete a Product",
     *     description="Deletes a Product by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Product ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="No Content"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Category not found")
     *         )
     *     )
     * )
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
