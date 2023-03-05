<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StrategicObjective extends Model
{
    use HasFactory;
    protected $primaryKey = 'strategic_objective_ID';

    public function measures()
    {
        return $this->hasMany(StrategicMeasure::class, 'strategic_objective_ID');
    }

    // public function opcr()
    // {
    //     return $this->belongsTo(Opcr::class, 'opcr_ID');
    // }
}
