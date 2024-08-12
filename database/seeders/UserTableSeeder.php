<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
            [
                'role_id' => '2',
                'name' => 'Supervisor',
                'email' => 'supervisor@localhost',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ]
        );
        DB::table('users')->insert(
            [
                'role_id' => '1',
                'name' => 'Admin',
                'email' => 'admin@localhost',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ]
        );
    }
}
