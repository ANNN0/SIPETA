<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            // Weight category (base unit: 1 kg)
            ['name' => 'Gram', 'symbol' => 'gram', 'category' => 'weight', 'base_unit_value' => 0.001],
            ['name' => 'Kilogram', 'symbol' => 'kg', 'category' => 'weight', 'base_unit_value' => 1],
            ['name' => 'Kuintal', 'symbol' => 'kwintal', 'category' => 'weight', 'base_unit_value' => 100],
            ['name' => 'Ton', 'symbol' => 'ton', 'category' => 'weight', 'base_unit_value' => 1000],

            // Count category (no conversion)
            ['name' => 'Buah', 'symbol' => 'buah', 'category' => 'count', 'base_unit_value' => 1],
            ['name' => 'Ikat', 'symbol' => 'ikat', 'category' => 'count', 'base_unit_value' => 1],
            ['name' => 'Polybag', 'symbol' => 'polybag', 'category' => 'count', 'base_unit_value' => 1],
            ['name' => 'Pot', 'symbol' => 'pot', 'category' => 'count', 'base_unit_value' => 1],

            // Container category (no conversion)
            ['name' => 'Sachet', 'symbol' => 'sachet', 'category' => 'container', 'base_unit_value' => 1],
            ['name' => 'Botol', 'symbol' => 'botol', 'category' => 'container', 'base_unit_value' => 1],
            ['name' => 'Karung', 'symbol' => 'karung', 'category' => 'container', 'base_unit_value' => 1],
            ['name' => 'Box', 'symbol' => 'box', 'category' => 'container', 'base_unit_value' => 1],
            ['name' => 'Pack', 'symbol' => 'pack', 'category' => 'container', 'base_unit_value' => 1],
        ];

        DB::table('units')->insert($units);
    }
}
