<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Belong_to extends Model
{
    use HasFactory;
    protected $fillable = [
        'Product_ID',
        'Order_ID',
        'Quantity',
    ];
}