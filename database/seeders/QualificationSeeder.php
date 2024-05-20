<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Qualification;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $qualifications = [
            ['name' => 'Level 1 – Certificate I', 'group_type' => 'Under Graduate Qualifications'],
            ['name' => 'Level 2 – Certificate II', 'group_type' => 'Under Graduate Qualifications'],
            ['name' => 'Level 3 – Certificate III', 'group_type' => 'Under Graduate Qualifications'],
            ['name' => 'Level 4 – Certificate IV', 'group_type' => 'Under Graduate Qualifications'],
            ['name' => 'Level 5 – Diploma', 'group_type' => 'Under Graduate Qualifications'],
            ['name' => 'Level 6 – Advanced Diploma, Associate Degree', 'group_type' => 'Under Graduate Qualifications'],
            ['name' => 'Level 7 – Bachelor Degree', 'group_type' => 'Under Graduate Qualifications'],

            ['name' => 'Level 8 – Bachelor Honours Degree', 'group_type' => 'Postgraduate qualifications'],
            ['name' => 'Level 8 – Graduate Certificate', 'group_type' => 'Postgraduate qualifications'],
            ['name' => 'Level 8 – Graduate Diploma', 'group_type' => 'Postgraduate qualifications'],

            ['name' => 'Level 9 – Master’s Degree', 'group_type' => 'Postgraduate qualifications'],
            ['name' => 'Level 10 – Doctoral Degree', 'group_type' => 'Postgraduate qualifications'],
        ];


        foreach ($qualifications as $key => $qualification) {
            Qualification::updateOrCreate(
                ['name' => $qualification['name'], 'group_type' => $qualification['group_type']],
                ['name' => $qualification['name']]
            );
        }
    }
}
