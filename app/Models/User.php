<?php

namespace App\Models;

use App\Models\Division;
use App\Models\Evaluation;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $primaryKey = 'user_ID';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'first_name', 
        'last_name',
        'middle_name',
        'extension_name',
        'email', 
        'birthday',
        'password',
        'user_type_ID',
        'division_ID',
        'province_ID'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_ID');
    }

    // Define a relationship with the Evaluation model
    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}


