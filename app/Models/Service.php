<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'price',
        'unit',
        'description',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function transactionDetails()
    {
    return $this->hasMany(TransactionDetail::class);
    }
}