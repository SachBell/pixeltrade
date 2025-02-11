<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servers extends Model
{
    use HasFactory;

    protected $table = 'servers';

    protected $fillable = [
        'user_id',
        'name_server',
        'slug',
        'token',
        'status'
    ];

    public function serverUser()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serverCategorie()
    {
        return $this->hasMany(Categories::class, 'server_id');
    }

    public function serverProduct()
    {
        return $this->hasMany(Products::class, 'server_id');
    }

    public function serverOrders()
    {
        return $this->hasMany(Orders::class, 'server_id');
    }
}
