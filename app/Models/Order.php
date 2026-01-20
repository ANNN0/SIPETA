<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;

class Order extends Model
{
    use HasFactory;

    /**
     * Order has many order items
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Order has one transaction
     */
    public function transaction()
    {
        return $this->hasOne(Transaction::class);
    }

    /**
     * Order belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order has one return request
     */
    public function returnRequest()
    {
        return $this->hasOne(\App\Models\ReturnRequest::class);
    }
}
