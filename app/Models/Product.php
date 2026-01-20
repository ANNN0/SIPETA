<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use Hasfactory;

    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'featured',
        'quantity',
        'image',
        'images',
        'category_id',
        'region_id',
        'farmer_id',
        'harvest_period',
        'shelf_life',
        'organic_status',
        'storage_info',
        'production_date',
        'bpom_number',
        'composition',
        'expiry_date'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }


    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id');
    }

    public function farmer()
    {
        return $this->belongsTo(Farmer::class, 'farmer_id');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function approvedReviews()
    {
        return $this->hasMany(ProductReview::class)->where('is_approved', true);
    }

    /**
     * Get all product types for this product (many-to-many)
     */
    public function productTypes()
    {
        return $this->belongsToMany(ProductType::class, 'product_product_type');
    }

    /**
     * Get all unit prices for this product
     */
    public function unitPrices()
    {
        return $this->hasMany(ProductUnitPrice::class);
    }

    /**
     * Get the primary unit price for this product
     */
    public function primaryUnitPrice()
    {
        return $this->hasOne(ProductUnitPrice::class)->where('is_primary', true);
    }

    /**
     * Get price for a specific unit
     */
    public function getPriceForUnit($unitId)
    {
        return $this->unitPrices()->where('unit_id', $unitId)->first();
    }

    /**
     * Get all available units for this product
     */
    public function getAvailableUnits()
    {
        return $this->unitPrices()->with('unit')->get()->pluck('unit');
    }

    /**
     * Get formatted price with unit symbol (e.g., "Rp 15.000 / kg")
     */
    public function getFormattedPrice($unitId = null)
    {
        $unitPrice = $unitId
            ? $this->getPriceForUnit($unitId)
            : $this->primaryUnitPrice;

        if (!$unitPrice) return 'N/A';

        $price = number_format($unitPrice->getActivePrice(), 0, ',', '.');
        return "Rp {$price} / {$unitPrice->unit->symbol}";
    }

    /**
     * Get average rating of the product
     */
    public function getAverageRatingAttribute()
    {
        return round($this->approvedReviews()->avg('rating'), 1) ?: 0;
    }

    /**
     * Get count of approved reviews
     */
    public function getReviewCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
}
