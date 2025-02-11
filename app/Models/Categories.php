<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'server_id',
        'name_categorie',
    ];

    public function categorieServer()
    {
        return $this->belongsTo(Servers::class, 'server_id');
    }

    public function categorieProduct()
    {
        return $this->hasMany(Products::class, 'categorie_id');
    }
}
