<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Vendor extends Model implements AuthenticatableContract
{
    use HasFactory, Authenticatable, HasApiTokens;
    protected $guarded = [];

    public function walletTransactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }
    public function wallets()
    {
        return $this->hasOne(Wallet::class);
    }

}
