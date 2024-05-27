<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'category', 'image', 'description', 'status', 'views', 'likes'
    ];

    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
