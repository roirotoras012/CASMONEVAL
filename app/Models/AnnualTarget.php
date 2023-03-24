<?php

namespace App\Models;


use App\Models\StrategicMeasure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AnnualTarget extends Model
{
    use HasFactory;
    protected $primaryKey = 'annual_target_ID';

    public function strategicMeasure()
    {
        return $this->hasMany(StrategicMeasure::class);
    }
}
