<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'province',
        'description',
        'image',
    ];

    /**
     * Get all products from this region
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all farmers from this region
     */
    public function farmers()
    {
        return $this->hasMany(Farmer::class);
    }
}
