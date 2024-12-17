<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Use updateOrCreate for the Supervisor
        User::updateOrCreate(
            [
                'email' => 'supervisor@localhost', // Use email as a unique identifier
            ],
            [
                'role_id' => 2,
                'name' => 'Supervisor',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ]
        );

        // Use updateOrCreate for the Admin
        User::updateOrCreate(
            [
                'email' => 'admin@localhost', // Use email as a unique identifier
            ],
            [
                'role_id' => 1,
                'name' => 'Admin',
                'email_verified_at' => Carbon::now(),
                'password' => Hash::make('password')
            ]
        );
    }
}
