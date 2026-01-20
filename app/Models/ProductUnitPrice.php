<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductUnitPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'unit_id',
        'regular_price',
        'sale_price',
        'minimum_order',
        'is_primary'
    ];

    /**
     * Get the product that owns this price
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the unit for this price
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    /**
     * Get the active price (sale price if available, otherwise regular price)
     */
    public function getActivePrice()
    {
        return $this->sale_price ?? $this->regular_price;
    }
}
