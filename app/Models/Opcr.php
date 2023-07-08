<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcr extends Model
{
    protected $table = 'opcr';
    protected $primaryKey = 'opcr_ID';
    use HasFactory;


    public function objectives()
    {
        return $this->hasMany(Objective::class, 'opcr_ID');
    }
}
