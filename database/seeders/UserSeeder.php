<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Ar Rakin",
            "username" => "root",
            "email" => "rakinar2@onesoftnet.eu.org",
            "password" => "1234",
            "discord_id" => "1111111111111111"
        ]);
    }
}
