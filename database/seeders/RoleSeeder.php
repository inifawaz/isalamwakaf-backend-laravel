<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = Role::create([
            "name" => "Admin"
        ]);


        User::factory(30)->create();

        $admin = User::create([
            "name" => "Admin Satu",
            "address" => "Surakarta",
            "mobile" => "082133409998",
            "email" => "admin@gmail.com",
            "avatar_url" => 'avatar.jpg',
            "email_verified_at" => now(),
            "password" => Hash::make('password')
        ]);
        $admin->assignRole($adminRole);
    }
}
