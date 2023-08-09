<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScoreCard extends Model
{

    protected $table = 'scorecard';
    protected $primaryKey = 'id';

    protected $fillable = [
        'opcr_ID',
        'province_ID',
        'prepared_by',
        'reviewed_by_bdd',
        'reviewed_by_cpd',
        'approved_by',
    ];
    use HasFactory;
}
