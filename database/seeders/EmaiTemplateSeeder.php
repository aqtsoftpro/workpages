<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use App\Models\EmailTemplate;

class EmaiTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $email_templates = [
            [
               'name' => 'Admin Password Recovey',
               'email_type' => 'admin',
            ],
            [
                'name' => 'Admin Password Reset',
                'email_type' => 'admin',
            ],
            [
                'name' => 'Admin Recieve Company Email',
                'email_type' => 'admin',
            ],
            //companies
            [
                'name' => 'Company Account Verify',
                'email_type' => 'company',
            ],
            [
                'name' => 'Company Password Recovery',
                'email_type' => 'company',
            ],
            [
                'name' => 'Company Post Jobs',
                'email_type' => 'company',
            ],
            [
                'name' => 'Company Recieve Application',
                'email_type' => 'company',
            ],
            [
                'name' => 'Company Registration',
                'email_type' => 'company',
            ],

            //job seekers 
            [
                'name' => 'Job Seeker Verify Email',
                'email_type' => 'job seeker',
            ],
            [
                'name' => 'Job Seeker Registration',
                'email_type' => 'job seeker',
            ],
            [
                'name' => 'Job Seeker Email',
                'email_type' => 'job seeker',
            ],
            [
                'name' => 'Applied On Jobs',
                'email_type' => 'job seeker',
            ],
            [
                'name' => 'Short Listed Email',
                'email_type' => 'job seeker',
            ],
            
        ];

        foreach ($email_templates as $key => $template) {
            EmailTemplate::updateOrCreate(
                [
                    'name' => $template['name'], 
                    'email_type'=> $template['email_type']
                ],
                [
                    'name' => $template['name'],
                    'slug' => Str::slug($template['name']),
                    'tags' => "['subject']",
                    'email_type'=> $template['email_type']
                ]
            );
        }
    }
}
