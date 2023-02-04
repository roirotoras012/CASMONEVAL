<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\User;
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
         User::factory(27)->create();

        // $faker = Faker::create();

        // foreach(range(1, 27) as $index) {
        //     $firstName = $faker->firstName;
        //     $lastName = $faker->lastName;
        //     User::create([
        //     'username' => $firstName . '_' . $lastName,
        //     'email' => $firstName . '_' . $lastName . '@gmail.com',
        //     'last_name' => $lastName,
        //     'first_name' => $firstName,
        //     'middle_name' => fake()->name(),
        //     'birthday' => fake()->dateTimeBetween('1985-01-01', '2010-12-31')->format('d/m/Y'),
        //     'password' => 'RoneDev2023', // password
        //     'remember_token' => Str::random(10),
        //     ]);
        // }

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // add dummy data to user
    }
}
