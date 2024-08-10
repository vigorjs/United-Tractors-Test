<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'image',
        'product_category_id'
    ];

    public function categoryProduct()
    {
        return $this->belongsTo(CategoryProduct::class, 'id');
    }
}
