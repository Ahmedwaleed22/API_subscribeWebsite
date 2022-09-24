<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = ['title','url' , 'user_id'];

    public function post()
    {
        return $this->hasMany(Post::class);
    }

    public function subscribes()
    {
        return $this->belongsToMany(User::class , 'subscribes' , 'website_id' , 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribe()
    {
        return $this->hasMany(Subscribe::class);
    }
}
