<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Data role yang ingin dimasukkan atau diperbarui
        $arrayData = [
            'customer service',
            'supervisor',
        ];

        // Loop melalui setiap role dan gunakan updateOrCreate
        foreach ($arrayData as $data) {
            Role::updateOrCreate(
                [
                    'role_name' => $data, // Menggunakan role_name sebagai identifier
                ]
            );
        }
    }
}
