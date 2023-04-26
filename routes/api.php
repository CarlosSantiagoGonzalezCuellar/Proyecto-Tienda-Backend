<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::middleware('auth:sanctum')->group(function () {
    // ----------- RUTAS CRUD USERS ----------------
    Route::get('/', UserController::class);
    Route::controller(UserController::class)->group(function () {
        Route::post('user/create', 'create');
        Route::delete('user/delete', 'delete');
        Route::get('user/{opcion}', 'index');
        Route::patch('user/{opcion}', 'index');
    });

    // ----------- RUTAS CRUD ROLES ----------------
    Route::controller(RoleController::class)->group(function () {
        Route::post('role/create', 'create');
        Route::delete('role/delete', 'delete');
        Route::get('role/{opcion}', 'index');
        Route::patch('role/{opcion}', 'index');
    });

    // ----------- RUTAS CRUD PRODUCTS ----------------
    Route::controller(ProductController::class)->group(function () {
        Route::post('product/create', 'create');
        Route::delete('product/delete', 'delete');
        Route::get('product/{opcion}', 'index');
        Route::patch('product/{opcion}', 'index');
    });

    // ----------- RUTAS CRUD CATEGORIES ----------------
    Route::controller(CategoryController::class)->group(function () {
        Route::get('category', 'getProductsOfCategory');
        Route::post('category/create', 'create');
        Route::delete('category/delete', 'delete');
        Route::get('category/{opcion}', 'index');
        Route::patch('category/{opcion}', 'index');
    });
// });

// ----------- RUTA LOGIN ----------------
Route::post('auth', [AuthController::class, 'login']);
