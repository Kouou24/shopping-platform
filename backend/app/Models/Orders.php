<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'Customer_ID',
        'Coupon_ID',
        'Order_Date',
        'Paid_Date',
        'Deliver_Address',
        'TotalPrice',
    ];
}
