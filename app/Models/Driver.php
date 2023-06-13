<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        return $this->hasMany(AnnualTarget::class, 'driver_ID');
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
