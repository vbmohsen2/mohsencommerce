<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTags extends Model
{
    protected $fillable=['name'];
    public function posts()
    {
        return $this->belongsToMany(Posts::class, 'post_post_tags', 'tag_id', 'post_id');
    }
}
