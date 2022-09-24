<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title','description','website_id'];

    public function website(){
        return $this->belongsTo(website::class);
    }

    public function scopeGetNotifiablePosts($query)
    {
        $condition = function ($query) {
            $query->whereDoesntHave('notifiedPosts', function ($query) {
                $query->where('notified_posts.post_id', '!=', 'posts.id');
            });
        };
        return $query->whereHas('website', function ($query) use ($condition) {
            $query->whereHas('subscribe', $condition);
        })->with(['website' => function ($query) use ($condition) {
            $query->with(['subscribe' => $condition]);
        }])->get();
    }

}
