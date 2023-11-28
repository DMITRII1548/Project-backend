<?php
namespace App\Services\Category;

use App\Models\Category;

class CategoryService {
    public function store($info)
    {
        if (Category::create($info)) {
                return 'good';
            } else {
                return 'bad';
        }
    }

    public function update($category, $info)
    {
        if ($category->update($info)) {
            return 'good';
        } else {
            return 'bad';
        }
    }
}
