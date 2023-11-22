<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * GET /products - список продуктів
     * @return JsonResponse
     */
    public function getProducts(): JsonResponse
    {
        $products = Product::with('user')->get();
        return response()->json($products);
    }

    /**
     * POST /products - створити новий продукт
     * @param Request $request
     * @return JsonResponse
     */
    public function createProduct(Request $request): JsonResponse
    {
        $product = new Product();
        $product->fill($request->only(['title', 'description', 'price']));

        $product->save();

        foreach ($request->input('users_id', []) as $userId) {
            $user = User::find($userId);
            if ($user) {
                $product->user()->associate($user)->save();
            }
        }

        return response()->json($product);
    }

    /**
     * GET /products/{id} - отримати продукт по id
     * @param $id
     * @return JsonResponse
     */
    public function getProductById($id): JsonResponse
    {
        $product = Product::with('user')->find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        return response()->json($product);
    }

    /**
     * PUT|PATCH /products/{id} - оновити продукт по id
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateProduct(Request $request, $id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $product->update($request->only(['title', 'description', 'price']));

        $product->user()->dissociate();
        foreach ($request->input('users_id', []) as $userId) {
            $user = User::find($userId);
            if ($user) {
                $product->user()->associate($user)->save();
            }
        }

        return response()->json($product);
    }

    /**
     * DELETE /products/{id} - видалити продукт
     * @param $id
     * @return JsonResponse
     */
    public function deleteProduct($id): JsonResponse
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['error' => 'Product not found.'], 404);
        }

        $product->delete();

        return response()->json(['message' => 'Product deleted successfully.']);
    }
}
