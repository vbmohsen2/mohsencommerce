<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');

    }
    public function postmedia()
    {
        return $this->hasMany(PostMedias::class, 'post_id');
    }
    public function PostComments()
    {
        return $this->hasMany(PostComments::class, 'post_id');
    }

    public function category()
    {
        return $this->belongsTo(PostCategory::class, 'post_category_id');
    }
    public function postTags()
    {
        return $this->belongsToMany(PostTags::class, 'post_post_tags', 'post_id', 'tag_id');
    }

    public function postBigbanner()
    {
        return $this->hasOne(PostBigbanner::class, 'Post_id');
    }



    public function getCreatedAtFormattedAttribute()
    {
        return Carbon::parse($this->created_at)->locale('fa')->translatedFormat('j F Y');
    }
    public function getTimeAgoAttribute()
    {
        return Carbon::parse($this->created_at)->locale('fa')->diffForHumans();
    }
}
