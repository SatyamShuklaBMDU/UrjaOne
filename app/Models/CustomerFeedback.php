<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerFeedback extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'reply_datetime' => 'datetime',
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
