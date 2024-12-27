<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    use HasFactory;

    protected $table = 'products'; // 對應資料表名稱
    protected $primaryKey = 'Product_ID'; // 自定義主鍵
    public $timestamps = true; // 如果沒有 timestamps 欄位，設為 false

    // 如果不允許大量賦值保護，需指定可填充的欄位
    protected $fillable = [
        'Product_ID',
        'Seller_ID',
        'Product_Name',
        'Product_Description',
        'Price',
        'Release_date',
        'Stock_quantity',
        'imgLink',
    ];
}
