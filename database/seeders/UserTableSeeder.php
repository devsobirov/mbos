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
        if (!DB::table('users')->where('email', 'adminpost')->exists()) {
            User::create([
                'name' => 'Админ',
                'email' => 'admin',
                'password' => Hash::make('secret')
            ]);
        }
    }
}
