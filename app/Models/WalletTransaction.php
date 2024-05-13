<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function Walletdetails()
    {
        return $this->belongsTo(Wallet::class,'wallet_id');
    }
    public function userdetails()
    {
        return $this->belongsTo(Vendor::class,'vendor_id');
    }
}
