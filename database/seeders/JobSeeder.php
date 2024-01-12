<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class JobSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 50; $i++) {
        $jobTitle = fake()->sentence();
        DB::table('jobs')->insert([
            'job_key' => Str::random(10),
            'job_title' => $jobTitle,
            'job_slug' => Str::slug($jobTitle, '-'),
            'company_id' => fake()->randomNumber(2),
            'location_id' => fake()->randomNumber(1),
            'job_description' => fake()->paragraph(),
            'job_type_id' => fake()->randomNumber(1),
            'vacancy' => fake()->randomNumber(1),
            'qualification_id' => fake()->randomNumber(1),
            'experience' => fake()->randomNumber(1),
            'gender' => 'Male',
            'salary_from' => fake()->randomNumber(4),
            'salary_to' => fake()->randomNumber(5),
            'currency_id' => fake()->randomNumber(1),
            'expiration' => fake()->dateTimeThisCentury->format('Y-m-d'),
            'job_responsibilities' => fake()->title(),
            'working_mode' => 'Full Time',
            'payment_mode' => 'Per Month',
            'category_id' => fake()->randomNumber(2),
            'status' => 'active',
        ]);
        }    
    }
}
