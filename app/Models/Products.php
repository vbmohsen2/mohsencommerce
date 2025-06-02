<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    /** @use HasFactory<\Database\Factories\ProductsFactory> */
    use HasFactory;


    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_items')->withPivot(['quantity', 'price', 'total_price', 'discount']);
    }

    protected $casts = [
        'attributes' => 'array',
    ];

    public function template()
    {
        return $this->belongsTo(AttributeTemplate::class, 'attribute_template_id');
    }
}
