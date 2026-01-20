<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'location',
        'region_id',
        'description',
        'photo',
        'certification',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($farmer) {
            if (empty($farmer->slug)) {
                $farmer->slug = \Illuminate\Support\Str::slug($farmer->name);
            }
        });
    }

    /**
     * Get all products from this farmer
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the region this farmer belongs to
     */
    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
