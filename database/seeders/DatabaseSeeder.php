<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\User;
use App\Division;
use App\Province;
use App\UserType;
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

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // add dummy data to user
    }
}
