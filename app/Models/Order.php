<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'order_id';

    protected $fillable = [
        'customer_name',
        'payment_method',
        'item_name',
        'quantity',
        'price',
        'total_amount',
    ];
}