<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Degree;

class DegreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Degree::create([
            'degreeTitle' => 'High School', 
        ]);

        Degree::create([
            'degreeTitle' => 'BSc', 
        ]);

        Degree::create([
            'degreeTitle' => 'MSc', 
        ]);

        
    }
}
