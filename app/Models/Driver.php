<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\StrategicMeasure;
use Illuminate\Support\Facades\DB;
class Driver extends Model
{
    use HasFactory;
    protected $primaryKey = 'driver_ID';
    
    public function measures()
    {
        return $this->hasMany(StrategicMeasure::class, 'driver_ID');
    }
    public function targets()
    {
        return $this->hasMany(AnnualTarget::class, 'driver_ID')
        ->join('strategic_measures', 'annual_targets.strategic_measures_ID', '=', 'strategic_measures.strategic_measure_ID')
        ->orderBy('strategic_measures.strategic_objective_id', 'asc')
        ->orderBy(DB::raw('CAST(strategic_measures.number_measure AS UNSIGNED)'), 'asc')
        ->orderBy('strategic_measures.created_at', 'asc')
        ->select('annual_targets.*', 'strategic_measures.sum_of');
    }

    public function opcr()
    {
        return $this->belongsTo(Opcr::class, 'opcr_ID');
    }

    public function division()
    {
        return $this->belongsTo(Division::class, 'division_ID');
    }
}
