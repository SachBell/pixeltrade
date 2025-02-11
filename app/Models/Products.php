<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'server_id',
        'categorie_id',
        'name_product',
        'description',
        'price',
        'command',
    ];

    public function productServer()
    {
        return $this->belongsTo(Servers::class, 'server_id');
    }

    public function productCategorie()
    {
        return $this->belongsTo(Categories::class, 'categorie_id');
    }

    public function productOrder()
    {
        return $this->hasMany(Orders::class, 'product_id');
    }
}
