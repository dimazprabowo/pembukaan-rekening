<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arrayData = [
            'customer service',
            'supervisor',
        ];
        foreach ($arrayData as $data) {
            DB::table('role')->insert(
                [
                    'role_name' => $data,
                ]
            );
        }

    }
}
