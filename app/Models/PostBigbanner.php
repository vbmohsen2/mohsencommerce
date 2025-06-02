<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostBigbanner extends Model
{
    public function post()
    {
        return $this->belongsTo(Posts::class, 'Post_id');
    }
}
