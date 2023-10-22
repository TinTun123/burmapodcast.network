<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class StatisticsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $faker = Faker::create();



        // Seed fake data for the "statistics" table
        for ($i = 1; $i <= 50; $i++) { // You can adjust the number of records as needed
            DB::table('statistics')->insert([
                'show_id' => $faker->numberBetween(2, 3), // Random show_id between 2 and 9
                'episode_id' => $faker->randomElement([14, 15, 16]), // Random episode_id among 14, 15, and 16
                'ip_address' => $faker->ipv4,
                'audience_id' => $faker->numberBetween(6, 31), // Modify as needed
                'city' => $faker->city,
                'country' => $faker->country,
                'action' => $faker->randomElement(['listen', 'like']),
                'created_at' => $faker->dateTimeBetween('2020-8-1', '2020-9-31')
            ]);
        }
    }
}
