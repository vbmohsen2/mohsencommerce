<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productslikes extends Model
{
    protected $fillable = ['users_id', 'products_id', 'like','rating'];
}
