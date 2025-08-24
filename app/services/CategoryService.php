<?php
namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public static function getActiveCategories()
    {
        $categories = Category::where('is_active', 1)->get();

        $parents = $categories->whereNull('parent_id')->merge(
            $categories->where('parent_id', 0)
        );

        $children = $categories->whereNotIn('id', $parents->pluck('id'));

        return [
            'parents' => $parents->values(),   // .values() برای اندکس درست توی JSON
            'children' => $children->values(),
        ];
    }
}
