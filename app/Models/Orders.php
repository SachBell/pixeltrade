<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'server_id',
        'product_id',
        'transaction_id'
    ];

    public function orderUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderServer()
    {
        return $this->belongsTo(Servers::class, 'server_id');
    }

    public function orderProduct()
    {
        return $this->belongsTo(Products::class, 'product_id');
    }

    public function orderPayment()
    {
        return $this->hasMany(Payments::class, 'order_id');
    }
}
