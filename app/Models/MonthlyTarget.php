<?php

namespace App\Models;

use App\Models\AnnualTarget;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MonthlyTarget extends Model
{
    use HasFactory;
    protected $primaryKey = 'monthly_target_ID';

    public function annualTarget()
    {
        return $this->belongsTo(AnnualTarget::class);
    }
}
