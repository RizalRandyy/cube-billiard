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
            'name' => 'User',
            'email' => 'user@gmail.com',
            'phone' => '08324892734',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole($userRole);
    }
}
