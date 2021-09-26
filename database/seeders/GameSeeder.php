<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('games')->truncate();
        $faker = Factory::create();

        // for ($j = 0; $j < 10; $j++)
        // {
        $games = [];
        for ($i = 0; $i < 100; $i++)
        {
            $games[] =
                [
                    'title' => $faker->words($faker->numberBetween(1, 3), true),
                    'description' => $faker->sentence,
                    'publisher' => $faker->randomElement(['Atari', 'SEGA', 'Relict', 'CD Project', 'Indepence', 'Ubisoft', 'EA']),
                    'genere_id' => $faker->numberBetween(1, 5),
                    'score' => $faker->numberBetween(1, 100),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now()
                ];
        }

        DB::table('games')->insert($games);
        //}

        // for ($i = 0; $i < 1000; $i++)
        // {
        //     DB::table('games')->insert([
        //         'title' => $faker->words($faker->numberBetween(1, 3), true),
        //         'description' => $faker->sentence,
        //         'publisher' => $faker->randomElement(['Atari', 'SEGA', 'Relict', 'CD Project', 'Indepence', 'Ubisoft', 'EA']),
        //         'genere_id' => $faker->numberBetween(1, 5),
        //         'created_at' => Carbon::now(),
        //         'updated_at' => Carbon::now()
        //     ]);
        // }
    }
}
