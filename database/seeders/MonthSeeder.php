<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MonthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $months = [
            ['id' => 1, 'name' => 'Jan'],
            ['id' => 2, 'name' => 'Feb'],
            ['id' => 3, 'name' => 'Mar'],
            ['id' => 4, 'name' => 'Apr'],
            ['id' => 5, 'name' => 'May'],
            ['id' => 6, 'name' => 'Jun'],
            ['id' => 7, 'name' => 'Jul'],
            ['id' => 8, 'name' => 'Aug'],
            ['id' => 9, 'name' => 'Sep'],
            ['id' => 10, 'name' => 'Oct'],
            ['id' => 11, 'name' => 'Nov'],
            ['id' => 12, 'name' => 'Dec'],
        ];

        DB::table('month_names')->insert($months);
    }
}
