<?php

namespace Database\Seeders;

use App\Models\PoolTableModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoolTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PoolTableModel::create([
            'name' => '1',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 0,
            'orientation' => 'horizontal',
        ]);

        PoolTableModel::create([
            'name' => '2',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 3,
            'y' => 0,
            'orientation' => 'horizontal',
        ]);

        PoolTableModel::create([
            'name' => '3',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 2,
            'orientation' => 'horizontal',
        ]);

        PoolTableModel::create([
            'name' => '4',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 3,
            'y' => 2,
            'orientation' => 'horizontal',
        ]);

        PoolTableModel::create([
            'name' => '5',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 4,
            'orientation' => 'horizontal',
        ]);

        PoolTableModel::create([
            'name' => '6',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 3,
            'y' => 4,
            'orientation' => 'horizontal',
        ]);

        PoolTableModel::create([
            'name' => '7',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 0,
            'y' => 6,
            'orientation' => 'horizontal',
        ]);

        PoolTableModel::create([
            'name' => '8',
            'price_per_hour' => 70000,
            'status' => 1,
            'x' => 3,
            'y' => 6,
            'orientation' => 'horizontal',
        ]);
        
    }
}
