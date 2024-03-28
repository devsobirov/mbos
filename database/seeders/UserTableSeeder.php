<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    public function run()
    {
        if (!DB::table('users')->where('email', 'admin')->exists()) {
            User::create([
                'name' => 'Админ',
                'email' => 'admin',
                'password' => Hash::make('secret'),
                'role' => User::ROLE_ADMIN
            ]);
        }

        if (!DB::table('users')->where('email', 'worker')->exists()) {
            User::create([
                'name' => 'Ходим 1',
                'email' => 'worker',
                'password' => Hash::make('secret'),
                'role' => User::ROLE_WORKER
            ]);
        }

        if (!DB::table('users')->where('email', 'worker2')->exists()) {
            User::create([
                'name' => 'Ходим 2',
                'email' => 'worker2',
                'password' => Hash::make('secret'),
                'role' => User::ROLE_WORKER
            ]);
        }
    }
}
