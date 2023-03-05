<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategicMeasure extends Model
{
    use HasFactory;
    protected $primaryKey = 'strategic_measure_ID';
   
    public function objective()
    {
        return $this->belongsTo(StrategicObjective::class, 'strategic_objective_ID');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_ID');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_ID');
    }
}
