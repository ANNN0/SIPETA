<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'reviewer_name',
        'reviewer_email',
        'rating',
        'review_text',
        'image',
        'is_approved',
    ];

    protected $casts = [
        // is_approved removed from casts to allow null (pending), true (approved), false (rejected)
        'rating' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
