<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function tagsCount()
    {
        return $this->posts()
            ->join('post_tag', 'post_id', 'posts.id')
            ->selectRaw('category_id, count(distinct tag_id) as total')
            ->groupBy('category_id');
    }

    public function getTagsCountAttribute()
    {
        if(!array_key_exists('tagsCount', $this->relations))
            $this->load('tagsCount');

        $exists = $this->getRelation('tagsCount')->first();

        return $exists ? $exists->total : 0;
    }
}
