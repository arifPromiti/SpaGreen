<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WalletTrans extends Model
{
    protected $fillable = [
        'wallet_id',
        'user_id',
        'balance',
        'trans_type',
        'name',
        'card_number',
        'card_exp_date',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
