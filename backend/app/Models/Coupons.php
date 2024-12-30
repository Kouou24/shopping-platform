<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    use HasFactory;

    protected $fillable = [
        'Admin_ID',
        'Seller_ID',
        'Coupon_Name',
        'Discount',
        'Start_time',
        'End_time',
    ];
}
