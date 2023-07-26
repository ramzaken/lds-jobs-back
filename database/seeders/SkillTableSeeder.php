<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;

class SkillTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills   = [
            [
                'name'  =>  'Accountant',
            ],
            [
                'name'  =>  'Admin Support',
            ],
            [
                'name'  =>  'Affiliate Marketing Manager',
            ],
            [
                'name'  =>  'Alibaba Virtual Assistant',
            ],
            [
                'name'  =>  'Amazon Virtual Assistant',
            ],
            [
                'name'  =>  'Android Developer',
            ],
            [
                'name'  =>  'Animators',
            ],
            [
                'name'  =>  'Appointment Setter',
            ],
            [
                'name'  =>  'Back-End Developer',
            ],
            [
                'name'  =>  'Billing Specialist',
            ],
            [
                'name'  =>  'Bookkeeper',
            ],
            [
                'name'  =>  'Bookkeeping Virtual Assistant',
            ],
            [
                'name'  =>  'Chat Support Specialist',
            ],
            [
                'name'  =>  'ClickFunnels Expert',
            ],
            [
                'name'  =>  'Cold Callers',
            ],
            [
                'name'  =>  'Content Writer',
            ],
            [
                'name'  =>  'Copywriter',
            ],
            [
                'name'  =>  'Customer Service Representative',
            ],
            [
                'name'  =>  'Data Entry Virtual Assistant',
            ],
            [
                'name'  =>  'Digital Marketer',
            ],
            [
                'name'  =>  'Digital Marketing Virtual Assistant',
            ],
            [
                'name'  =>  'ECommerce Virtual Assistant',
            ],
            [
                'name'  =>  'Ebay Virtual Assistant',
            ],
            [
                'name'  =>  'Email Marketer',
            ],
            [
                'name'  =>  'Etsy Virtual Assistant',
            ],
            [
                'name'  =>  'FBA Virtual Assistant',
            ],
            [
                'name'  =>  'Facebook Ads Manager',
            ],
            [
                'name'  =>  'Facebook Virtual Assistant',
            ],
            [
                'name'  =>  'Front-End Developer',
            ],
            [
                'name'  =>  'Google Ads Manager',
            ],
            [
                'name'  =>  'Graphic Design Virtual Assistant',
            ],
            [
                'name'  =>  'Graphic Designer',
            ],
            [
                'name'  =>  'HTML5 Developer',
            ],
            [
                'name'  =>  'IOS Developer',
            ],
            [
                'name'  =>  'Instagram Marketer',
            ],
            [
                'name'  =>  'Instagram Virtual Assistant',
            ],
            [
                'name'  =>  'Java Developer',
            ],
            [
                'name'  =>  'Lazada Virtual Assistant',
            ],
            [
                'name'  =>  'Lead Generation Specialist',
            ],
            [
                'name'  =>  'Link Building Specialist',
            ],
            [
                'name'  =>  'Linux Developer',
            ],
            [
                'name'  =>  'MacOS Developer',
            ],
            [
                'name'  =>  'Mobile App Developer',
            ],
            [
                'name'  =>  'Mortgage Broker Virtual Assistant',
            ],
            [
                'name'  =>  'Operations Manager',
            ],
            [
                'name'  =>  'PPC Manager',
            ],
            [
                'name'  =>  'Paralegal',
            ],
            [
                'name'  =>  'Personal Assistant',
            ],
            [
                'name'  =>  'Pinterest Virtual Assistant',
            ],
            [
                'name'  =>  'Podcast Editor',
            ],
            [
                'name'  =>  'Podcast Virtual Assistant',
            ],
            [
                'name'  =>  'Programmer',
            ],
            [
                'name'  =>  'Project Managers',
            ],
            [
                'name'  =>  'Python Developer',
            ],
            [
                'name'  =>  'Quickbooks Bookkeeper',
            ],
            [
                'name'  =>  'ReactJS Developer',
            ],
            [
                'name'  =>  'Real Estate Virtual Assistant',
            ],
            [
                'name'  =>  'Recruitment Assistant',
            ],
            [
                'name'  =>  'Researcher',
            ],
            [
                'name'  =>  'SEO Expert',
            ],
            [
                'name'  =>  'Sales Reps',
            ],
            [
                'name'  =>  'Shopify Developer',
            ],
            [
                'name'  =>  'Shopify Virtual Assistant',
            ],
            [
                'name'  =>  'Social Media Manager',
            ],
            [
                'name'  =>  'Social Media Virtual Assistant',
            ],
            [
                'name'  =>  'Technical Support Representative',
            ],
            [
                'name'  =>  'Telemarketer',
            ],
            [
                'name'  =>  'Video Editor',
            ],
            [
                'name'  =>  'Virtual Assistant',
            ],
            [
                'name'  =>  'Virtual Executive Assistant',
            ],
            [
                'name'  =>  'Virtual Personal Assistant',
            ],
            [
                'name'  =>  'Walmart Virtual Assistant',
            ],
            [
                'name'  =>  'Web Designer',
            ],
            [
                'name'  =>  'Web Developer',
            ],
            [
                'name'  =>  'WordPress Developer',
            ],
            [
                'name'  =>  'Xero Bookkeeper'
            ]
        ];   

        $array  =   [];
        foreach ($skills as $s => $skill) {
            $array[]    =   [   
                                'name'          =>  $skill['name'],
                                'description'   =>  null,
                                'created_at'    =>  date('Y-m-d H:i:s')
                            ];
        }
        DB::table('skills')->truncate();
        DB::table('skills')
        ->insert($array);
    }
}
