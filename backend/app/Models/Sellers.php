<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sellers extends Model
{
    use HasFactory;

    protected $fillable = [
        'Member_ID',
        'Seller_description',
    ];
}
