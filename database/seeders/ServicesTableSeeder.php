<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ServicesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('services')->delete();
        
        \DB::table('services')->insert(array (
            0 => 
            array (
                'id' => 1,
                'tokens' => 9000,
                'title' => 'Pro',
                'price' => '9.99',
                'description' => 'Access to all tools
Unlimited user seats
Unlimited projects
25+ languages
API access
Wordpress plugin
SEO keyword research',
                'role_id' => 5,
                'active' => 1,
                'trial' => 0,
                'trial_period' => NULL,
                'trial_period_format' => NULL,
                'plan_period' => 1,
                'plan_period_format' => 'M',
                'created_at' => '2023-02-16 05:53:15',
                'updated_at' => '2023-02-17 14:42:50',
            ),
        ));
        
        
    }
}