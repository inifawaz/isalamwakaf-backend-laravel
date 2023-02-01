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


        $admin = User::create([
            "name" => "Admin Satu",
            "address" => "Surakarta",
            "mobile" => "082133409998",
            "email" => "admin1@gmail.com",
            "avatar_url" => 'avatar.jpg',
            "email_verified_at" => now(),
            "password" => Hash::make('password')
        ]);
        $admin->assignRole($adminRole);
        $admin2 = User::create([
            "name" => "Admin Dua",
            "address" => "Jepara",
            "mobile" => "082122334456",
            "email" => "admin2@gmail.com",
            "avatar_url" => 'avatar.jpg',
            "email_verified_at" => now(),
            "password" => Hash::make('password')
        ]);
        $admin2->assignRole($adminRole);
        User::create([
            "name" => "User Satu",
            "address" => "Jakarta",
            "mobile" => "082133405952",
            "email" => "user1@gmail.com",
            "avatar_url" => 'avatar.jpg',
            "email_verified_at" => now(),
            "password" => Hash::make('password')
        ]);
        User::create([
            "name" => "User Dua",
            "address" => "Bandung",
            "mobile" => "082133994844",
            "email" => "user2@gmail.com",
            "avatar_url" => 'avatar.jpg',
            "email_verified_at" => now(),
            "password" => Hash::make('password')
        ]);
    }
}
