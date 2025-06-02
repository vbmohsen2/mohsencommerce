<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostComments extends Model
{
    public function posts()
    {
        return $this->belongsTo(Posts::class);
    }
}
