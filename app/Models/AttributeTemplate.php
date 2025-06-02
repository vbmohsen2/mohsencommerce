<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeTemplate extends Model
{
    use HasFactory;

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }


    // برای اینکه بتونیم از Mass Assignment استفاده کنیم، فیلدهایی که می‌خواهیم پر بشن رو در این آرایه قرار میدیم.
    protected $fillable = [
        'name', // اضافه کردن نام به آرایه fillable
    ];
}
