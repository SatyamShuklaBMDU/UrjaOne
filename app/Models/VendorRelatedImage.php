<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorRelatedImage extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function VendorDetail(){
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
