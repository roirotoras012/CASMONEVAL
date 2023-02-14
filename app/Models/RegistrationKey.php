<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistrationKey extends Model
{
    use HasFactory;

    protected $primaryKey = 'registration_key_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'registration_key',
        'Status', 
        'user_type_ID',
        'province_ID',
        'division_ID',
    ];
}
