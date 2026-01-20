<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'symbol', 'category', 'base_unit_value'];

    /**
     * Get all product unit prices that use this unit
     */
    public function productUnitPrices()
    {
        return $this->hasMany(ProductUnitPrice::class);
    }

    /**
     * Convert quantity from this unit to base unit (e.g., ton to kg)
     * For weight category: base unit is 1 kg
     * For other categories: no conversion (returns same value)
     */
    public function toBaseUnit($quantity)
    {
        return $quantity * $this->base_unit_value;
    }

    /**
     * Convert quantity from base unit to this unit (e.g., kg to ton)
     */
    public function fromBaseUnit($baseQuantity)
    {
        return $this->base_unit_value > 0
            ? $baseQuantity / $this->base_unit_value
            : 0;
    }
}
