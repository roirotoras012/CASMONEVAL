<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\User;
use App\Division;
use App\Province;
use App\UserType;
use Faker\Generator;
use App\AnnualTarget;
use App\StrategicMeasure;
use App\StrategicObjective;
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
        //create 27 dummy user
        User::factory(27)->create();
        //create 15 dummy StrategicObjective
        StrategicObjective::factory(15)->create();
        //create 15 dummy StrategicObjective
        StrategicMeasure::factory(26)->create();
        //create usertypes
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
        //create Province
        for ($i = 1; $i <= 5; $i++){
            Division::create(
                [
                    'division' => 'Business Development Division',
                    'province_ID' => $i
                ]
            );
        }

        for ($i = 1; $i <= 5; $i++){
            Division::create(
                [
                    'division' => 'Consumer Protection Division',
                    'province_ID' => $i
                ]
            );
        }

        for ($i = 1; $i <= 5; $i++){
            Division::create(
                [
                    'division' => 'Finance Administrative Division',
                    'province_ID' => $i
                ]
            );
        }

        //create Target for 15 stratMeasure for bdd
        for ($o = 1; $o <= 15; $o++){
            for ($i = 1; $i <= 5; $i++){
                AnnualTarget::create(
                    [
                        'strategic_measures_ID' => $o,
                        'division_ID' => $i
                    ]
                );
            }
        }
        //create Target for 7 stratMeasure for cpd
        for ($o = 16; $o <= 22; $o++){
            for ($i = 6; $i <= 10; $i++){
                AnnualTarget::create(
                    [
                        'strategic_measures_ID' => $o,
                        'division_ID' => $i
                    ]
                );
            }
        }
        //create Target for 4 stratMeasure for fad
        for ($o = 23; $o <= 26; $o++){
            for ($i = 11; $i <= 15; $i++){
                AnnualTarget::create(
                    [
                        'strategic_measures_ID' => $o,
                        'division_ID' => $i
                    ]
                );
            }
        }
       
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // add dummy data to user
    }
}
