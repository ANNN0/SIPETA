<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\Hasfactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Hasfactory;

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
