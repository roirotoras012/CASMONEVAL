<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'username', 
        'email', 
        'first_name', 
        'last_name',
        'middle_name',
        'extension_name',
        'birthday',
        'password',
        'user_type_ID',
    ];

    use HasFactory;
}
