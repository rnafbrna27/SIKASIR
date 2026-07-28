<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'transaction_id',
        'amount',
        'payment_method',
        'payment_date',
        'notes',
    ];

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}