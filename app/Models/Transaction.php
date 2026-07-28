<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'invoice',
        'customer_name',
        'total',
        'payment_status',
        'transaction_date',
        'notes',
    ];

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}