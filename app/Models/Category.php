<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }
    public function children()
    {
        return $this->hasMany(category::class, 'parent_id');
    }
    public function products()
    {
        return $this->hasMany(Products::class, 'category_id');
    }
    public function childrenRecursive()
    {
        return $this->hasMany(Category::class, 'parent_id')->with('childrenRecursive');
    }

    public function attribute_template()
    {
        return $this->belongsTo(AttributeTemplate::class, 'attribute_template_id');
    }
}
