<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPlans extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function Vendor()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
    protected $casts = [
        'expiration_date' => 'datetime'
    ];
}
