<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorComplaint extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'reply_datetime' => 'datetime',
    ];
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
}
