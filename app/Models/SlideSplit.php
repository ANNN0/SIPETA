<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideSplit extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'background_color',
        'background_image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
}
