<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', static function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'getUsers']);
Route::post('/users', [UserController::class, 'createUser']);
Route::get('/users/{id}', [UserController::class, 'getUserById']);
Route::put('/users/{id}', [UserController::class, 'updateUser']);
Route::patch('/users/{id}', [UserController::class, 'updateUser']); // as PUT alternative
Route::delete('/users/{id}', [UserController::class, 'deleteUser']);

Route::get('/products', [ProductController::class, 'getProducts']);
Route::post('/products', [ProductController::class, 'createProduct']);
Route::get('/products/{id}', [ProductController::class, 'getProductById']);
Route::put('/products/{id}', [ProductController::class, 'updateProduct']);
Route::patch('/products/{id}', [ProductController::class, 'updateProduct']); // as PUT alternative
Route::delete('/products/{id}', [ProductController::class, 'deleteProduct']);
