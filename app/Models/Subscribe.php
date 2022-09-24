<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Subscribe extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = ['user_id','website_id'];

    public function website(){
        return $this->belongsTo(website::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function notifiedPosts() {
        return $this->belongsToMany(Post::class, 'notified_posts', 'subscription_id');
    }
}
