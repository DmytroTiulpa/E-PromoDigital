<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * GET /users - список користувачів
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $users = User::with('products')->get();
        return response()->json($users);
    }

    /**
     * POST /users - створити нового користувача
     * @param Request $request
     * @return JsonResponse
     */
    public function createUser(Request $request): JsonResponse
    {
        //$faker = Faker::create();

        $user = new User();
        $user->fill($request->only(['first_name', 'last_name']));

        $user->save();

        foreach ($request->input('products_id', []) as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $user->products()->save($product);
            }
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $path = $avatar->storeAs('avatars', $user->id . '.' . $avatar->getClientOriginalExtension(), 'public');
            $user->avatar = $path;
            $user->save();
        }

        return response()->json($user);
    }

    /**
     * GET /users/{id} - отримати користувача по id
     * @param $id
     * @return JsonResponse
     */
    public function getUserById($id): JsonResponse
    {
        $user = User::with('products')->find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $amount = $user->products->sum('price');
        $user->amount = $amount;

        return response()->json($user);
    }

    /**
     * PUT|PATCH /users/{id} - оновити користувача по id
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function updateUser(Request $request, $id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $user->update($request->only(['first_name', 'last_name']));

        $user->products()->detach();
        foreach ($request->input('products', []) as $productId) {
            $product = Product::find($productId);
            if ($product) {
                $user->products()->save($product);
            }
        }

        return response()->json($user);
    }

    /**
     * DELETE /users/{id} - видалити користувача
     * @param $id
     * @return JsonResponse
     */
    public function deleteUser($id): JsonResponse
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }

}
