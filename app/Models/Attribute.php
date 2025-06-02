<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    protected $fillable = [
        'attribute_template_id',
        'name',
        'slug',
        'input_type',
        'unit',
        'options',
        'is_filterable'
    ];

    protected $casts = [
        'options' => 'array',
        'is_filterable' => 'boolean',
    ];

    public function template()
    {
        return $this->belongsTo(AttributeTemplate::class, 'attribute_template_id');
    }
}
