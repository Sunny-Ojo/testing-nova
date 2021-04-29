<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    public function blog()
    {
        return $this->belongsTo(Blog::class);
    }
    public static function boot()
    {
        parent::boot();

        static::creating(function ($comment) {
            $comment->user_id = auth()->user()->id;
        });
    }
}
