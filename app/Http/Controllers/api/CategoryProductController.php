<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryProductRequest;
use App\Http\Requests\UpdateCategoryProductRequest;
use App\Models\CategoryProduct;
use App\Services\CategoryProductService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *     schema="CategoryProduct",
 *     type="object",
 *     title="Category Product",
 *     required={"id", "name"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Electronics"),
 *     @OA\Property(property="description", type="string", example="Category for electronic items"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2024-08-10T00:00:00.000000Z")
 * )
 *
 * @OA\Schema(
 *     schema="StoreCategoryProductRequest",
 *     type="object",
 *     title="Store Category Product Request",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Electronics"),
 *     @OA\Property(property="description", type="string", example="Category for electronic items")
 * )
 *
 * @OA\Schema(
 *     schema="UpdateCategoryProductRequest",
 *     type="object",
 *     title="Update Category Product Request",
 *     required={"name"},
 *     @OA\Property(property="name", type="string", example="Updated Electronics"),
 *     @OA\Property(property="description", type="string", example="Updated description for electronic items")
 * )
 */
class CategoryProductController extends Controller
{
    protected $categoryProductService;

    public function __construct(CategoryProductService $categoryProductService){
        $this->categoryProductService = $categoryProductService;
    }

    /**
     * @OA\Get(
     *     path="/category-products",
     *     tags={"Category"},
     *     operationId="getCategories",
     *     summary="Get list of all categories",
     *     description="Returns list of all categories",
     *     @OA\Response(
     *         response=200,
     *         description="Success get all categories",
     *         @OA\JsonContent(type="array",
     *             @OA\Items(ref="#/components/schemas/CategoryProduct")
     *         )
     *     )
     * )
     */
    public function index(){
        return response()->json($this->categoryProductService->getAllCategories());
    }

    /**
     * @OA\Post(
     *     path="/category-products",
     *     tags={"Category"},
     *     operationId="storeCategory",
     *     summary="Create new category",
     *     description="Creates a new category",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/StoreCategoryProductRequest")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Category Created",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryProduct")
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
    public function store(StoreCategoryProductRequest $request){
        return response()->json($this->categoryProductService->createCategory($request), Response::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *     path="/category-products/{id}",
     *     tags={"Category"},
     *     operationId="getCategoryById",
     *     summary="Get category by ID",
     *     description="Returns a single category",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful Operation",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryProduct")
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
    public function show($id){
        try {
            return response()->json($this->categoryProductService->getCategoryById($id));
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Put(
     *     path="/category-products/{id}",
     *     tags={"Category"},
     *     operationId="updateCategory",
     *     summary="Update an existing category",
     *     description="Updates a category's information",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UpdateCategoryProductRequest")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Category Updated",
     *         @OA\JsonContent(ref="#/components/schemas/CategoryProduct")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Not Found",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="boolean", example=false),
     *             @OA\Property(property="message", type="string", example="Category not found")
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
    public function update(UpdateCategoryProductRequest $request, $id){
        try {
            return response()->json($this->categoryProductService->updateCategory($id, $request));
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Delete(
     *     path="/category-products/{id}",
     *     tags={"Category"},
     *     operationId="deleteCategory",
     *     summary="Delete a category",
     *     description="Deletes a category by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Category ID",
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
        $this->categoryProductService->deleteCategory($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
