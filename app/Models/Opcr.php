<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opcr extends Model
{
    protected $table = 'opcr';
    protected $primaryKey = 'opcr_ID';


    protected $fillable = [
        'prepared_by',
        'approved_by',
    ];
    use HasFactory;


    public function objectives()
    {
        return $this->hasMany(Objective::class, 'opcr_ID');
    }
}
