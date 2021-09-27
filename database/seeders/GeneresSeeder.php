<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class GeneresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('generes')->truncate();

        DB::table('generes')->insert(
            [
                ['name' => 'RPG', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'Adventures', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'FPS', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'Sport', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name' => 'Sim', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            ]
        );
    }
}
