<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(AdminTransactionTableSeeder::class);
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'role' => 1,
                'name' => 'admin',
                'email' => 'admin@websim.com',
                'password' => Hash::make('admin@123'),
                'recovery_password' => 'admin@123',
                'user_token' => Str::random(20)
            ],
        ]);
    }
}

class AdminTransactionTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('admin_transaction')->insert([
            [
                'user_id' => 1,
            ],
        ]);
    }
}

