<?php

namespace App\Models;

use App\Models\Driver;
use App\Models\Division;
use App\Models\AnnualTarget;
use App\Models\StrategicObjective;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function annualTarget()
    {
        return $this->belognsTo(AnnualTarget::class);
    }
}
