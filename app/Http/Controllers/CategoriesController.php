<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Category\BaseController;
use App\Http\Requests\category\CategoryRequest;
use App\Models\Category;
use App\Services\Category\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends BaseController
{
    /**
     * @param CategoryRequest $request
     * @return string
     */
    public function store(CategoryRequest $request, CategoryService $categoryService)
    {
        $data = $request->validated();
        if ($data) {
            return $categoryService->store($data);
        }
    }

    /**
     * @param CategoryRequest $request
     * @param Category $category
     * @return string
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        if ($data) {
            return $this->service->update($category, $data);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function delete(Category $category)
    {
        if ($category->delete()) {
            return 'successfully deleted';
        } else {
            return 'not deleted';
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Category::get();
    }

    public function show(Category $category)
    {
        return $category;
    }

    public function restoreCategory()
    {
        $categories = Category::withTrashed()->get();

        foreach ($categories as $category) {
            if ($category) {
                $category->restore();
            };
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function productsByCategory(Category $category)
    {
        return $category->products;
    }

    public function getInfo(Request $request)
    {
//        $product = Product::find(1);
//        return $product->client;
        $name = $request->query('name');

        $data = DB::table('orders')
            ->select(
                'clients.last_name_doc',
                'clients.first_name_doc',
                'products.name AS product',
                'categories.name AS Category',)
            ->leftJoin('clients', 'clients.id', '=', 'orders.client_id')
            ->leftJoin('products', 'products.id', '=', 'orders.product_id')
            ->leftJoin('categories', 'categories.id', '=', 'products.category_id')
            ->where('categories.name', '=', $name)
            ->get();

        return $data;
    }
}
