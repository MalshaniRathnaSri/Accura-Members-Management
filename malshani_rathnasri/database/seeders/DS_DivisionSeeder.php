<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DS_DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\DS_DivisionModel::insert([
            ['name' => 'Colombo 1'],
            ['name' => 'Colombo 2'],
            ['name' => 'Colombo 3'],
        ]);
    }
}
