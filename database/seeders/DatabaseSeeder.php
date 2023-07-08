<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Division;
use App\Models\Province;
use App\Models\UserType;
use Faker\Generator;
use App\Models\AnnualTarget;
use App\Models\MonthlyTarget;
use App\Models\StrategicMeasure;
use App\Models\StrategicObjective;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //create UserType
        UserType::create(['user_type' => 'Regional Director']);
        UserType::create(['user_type' => 'Regional Planning Officer']);
        UserType::create(['user_type' => 'Provincial Director']);
        UserType::create(['user_type' => 'Provincial Planning Officer']);
        UserType::create(['user_type' => 'Division Chief']);
        //create Province
        Province::create(['Province' => 'Bukidnun']);
        Province::create(['Province' => 'Lanao Del Norte']);
        Province::create(['Province' => 'Misamis Oriental']);
        Province::create(['Province' => 'Misamis Occidental']);
        Province::create(['Province' => 'Camiguin']);
        
    }
}
