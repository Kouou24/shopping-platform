<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'Nickname',
        'User_Account',
        'User_Password',
        'Email',
        'Address',
    ];
}
