<?php

namespace App\Models;

use Database\Factories\PostFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Post extends Model
{
    /** @use HasFactory<PostFactory> */
    use HasFactory, Notifiable;
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'image'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
