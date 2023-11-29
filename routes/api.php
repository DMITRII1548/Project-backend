<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Permissions\PermissionController;
use App\Http\Controllers\Permissions\RolesController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ClientsController;
use App\Http\Controllers\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('jwt:auth')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/home', function () {
    return ['message' => 'Hello World'];
});

Route::get('posts', function () {
    return ['posts' => [
        [
            'id' => 1,
            'title' => 'Programing',
            'description' => 'This post about programming',
            'body' => 'In 2023 we have a lot of good programming languages, the mos popular are: JavaScript, Php, Golang, Python', 'Java', 'C#', 'C++'
        ],
        [
            'id' => 2,
            'title' => 'University in Almaty',
            'description' => 'This post about universities that located In Almaty',
            'body' => 'If you want to join to universities, firstful you have to think about Almaty'
        ],
        [
            'id' => 3,
            'title' => 'Computers',
            'description' => 'This post about computers',
            'body' => 'Nowadays in companies use DeLL, Lenovo and etc. computers'
        ],

    ]];
});

Route::prefix('clients')->group(function () {
    Route::post('/', [ClientsController::class, 'store']);
});

Route::prefix('category')->group(function () {
        Route::post('restore-Category', [\App\Http\Controllers\CategoriesController::class, 'restoreCategory'])->middleware('checkAdminRole');
        Route::post('store-Category', [\App\Http\Controllers\CategoriesController::class, 'store'])->middleware('checkAdminRole');
        Route::put('update-Category/{category}', [\App\Http\Controllers\CategoriesController::class, 'update'])->middleware('checkAdminRole');
        Route::get('categories', [\App\Http\Controllers\CategoriesController::class, 'index']);
        Route::delete('delete-Category/{category}', [\App\Http\Controllers\CategoriesController::class, 'delete'])->middleware('checkAdminRole');
        Route::get('products-by-Category/{category}', [\App\Http\Controllers\CategoriesController::class, 'productsByCategory']);
        Route::get('/{category}', [\App\Http\Controllers\CategoriesController::class, 'show']);
});

Route::prefix('products')->group(function () {
    Route::get('/', [ProductsController::class, 'index']);
    Route::get('/{product}', [ProductsController::class, 'show']);
    Route::post('/', [ProductsController::class, 'store'])->middleware('checkAdminRole');
    Route::patch('/{product}', [ProductsController::class, 'update'])->middleware('checkAdminRole');
    Route::delete('/{product}', [ProductsController::class, 'delete'])->middleware('checkAdminRole');
});

Route::prefix('orders')->group(function () {
    Route::post('/', [OrdersController::class, 'store']);
    Route::get('/', [OrdersController::class, 'index'])->middleware('checkAdminRole');
    Route::delete('/{order}', [OrdersController::class, 'delete'])->middleware('checkAdminRole');
});

Route::prefix('post')->group(function () {
    Route::get('posts-controller', [PostsController::class, 'index']);
    Route::get('post/{id}', [PostsController::class, 'getPostById']);
    Route::get('post-all', [PostsController::class, 'getAll'])->middleware('checkAdminRole');;
    Route::post('post-create', [PostsController::class, 'create'])->middleware('checkAdminRole');

    Route::put('post-update/{post}', [PostsController::class, 'update'])->middleware('checkAdminRole');

//Second lesson laravel
    Route::post('post-store', [PostsController::class, 'store'])->middleware('checkAdminRole');
    Route::get('post-by-title/{title}', [PostsController::class, 'getPostByTitle']);
});

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class ,'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class ,'me']);

});

Route::post('register', [\App\Http\Controllers\RegisterController::class, 'register']);

// Create Role
Route::post('/roles', [RolesController::class, 'createRole'])->middleware(['jwt.auth']);;

// Get Roles
Route::get('/roles', [RolesController::class, 'getRoles'])->middleware(['jwt.auth']);;

// Find Role by Name
Route::get('/roles/{name}', [RolesController::class, 'getRolesByName'])->middleware(['jwt.auth']);;