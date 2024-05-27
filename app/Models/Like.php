<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;
    protected $fillable = ['likeable_type', 'likeable_id','blog_id'];

    public function likeable()
    {
        return $this->morphTo();
    }
}
