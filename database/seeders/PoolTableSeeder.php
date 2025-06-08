<?php

namespace Database\Seeders;

use App\Models\PoolTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PoolTable::create([
            'name' => '1',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 0,
            'orientation' => 'horizontal',
        ]);

        PoolTable::create([
            'name' => '2',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 1,
            'y' => 0,
            'orientation' => 'horizontal',
        ]);

        PoolTable::create([
            'name' => '3',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 1,
            'orientation' => 'horizontal',
        ]);

        PoolTable::create([
            'name' => '4',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 1,
            'y' => 1,
            'orientation' => 'horizontal',
        ]);

        PoolTable::create([
            'name' => '5',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 2,
            'orientation' => 'horizontal',
        ]);

        PoolTable::create([
            'name' => '6',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 1,
            'y' => 2,
            'orientation' => 'horizontal',
        ]);

        PoolTable::create([
            'name' => '7',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 3,
            'orientation' => 'horizontal',
        ]);

        PoolTable::create([
            'name' => '8',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 1,
            'y' => 3,
            'orientation' => 'horizontal',
        ]);
        
    }
}
