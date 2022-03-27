<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MachineSetting;

class MachineSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MachineSetting::insert([
            [
                'machine_id' => 1,
                'psum_min_value' => 1.20,
                'psum_max_value' => 350,
                'created_at' => now(),
            ],
            [
                'machine_id' => 2,
                'psum_min_value' => 1.20,
                'psum_max_value' => 350,
                'created_at' => now(),
            ]
        ]);
    }
}
