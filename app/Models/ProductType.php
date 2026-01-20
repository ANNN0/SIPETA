<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductType extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon'];

    /**
     * Get all products that have this product type
     * Many-to-many relationship via product_product_type pivot table
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_product_type');
    }
}
