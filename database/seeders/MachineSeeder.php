<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Machine;

class MachineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Machine::insert([
            [
                'name' => 'Pump',
                'slug' => 'pump',
                'created_at' => now(),
            ],
            [
                'name' => 'Compressor',
                'slug' => 'compressor',
                'created_at' => now(),
            ]
        ]);
    }
}
