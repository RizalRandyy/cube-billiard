<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kasirRole = Role::create([
            'name' => 'Kasir',
        ]);

        $kasir = User::create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'phone' => '08332892734',
            'password' => bcrypt('password'),
        ]);

        $kasir->assignRole($kasirRole);

        $adminRole = Role::create([
            'name' => 'Admin',
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phone' => '023847234',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole($adminRole);

        $userRole = Role::create([
            'name' => 'User',
        ]);

        $user = User::create([
            'name' => 'Rizal Randi Saputra',
            'email' => 'rizalrandy3@gmail.com',
            'phone' => '08324892734',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($userRole);

        $user2 = User::create([
            'name' => 'Raddit Azya Zul Putra',
            'email' => 'zul@gmail.com',
            'phone' => '08324892734',
            'password' => bcrypt('password'),
        ]);

        $user2->assignRole($userRole);
        
        $user3 = User::create([
            'name' => 'Hanif Aria Romansyah',
            'email' => 'hanif@gmail.com',
            'phone' => '08324892734',
            'password' => bcrypt('password'),
        ]);

        $user3->assignRole($userRole);

        $user4 = User::create([
            'name' => 'Handi Septian',
            'email' => 'handi@gmail.com',
            'phone' => '08324892734',
            'password' => bcrypt('password'),
        ]);

        $user4->assignRole($userRole);
    }
}
