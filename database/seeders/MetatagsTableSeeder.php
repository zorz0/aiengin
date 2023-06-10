<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MetatagsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('metatags')->delete();
        
        \DB::table('metatags')->insert(array (
            0 => 
            array (
                'id' => 17,
                'priority' => 23,
                'url' => '/',
                'info' => 'Homepage',
                'page_title' => 'Revolutionize Your Writing with AI Engine',
                'page_description' => 'Use AI to boost your traffic and save hours of work. Automatically write unique, engaging and high-quality copy or content: from long-form blog posts or landing pages to digital ads in seconds.',
            'page_keywords' => 'traffic, content generation, automation, unique content, engaging content, high-quality content, copywriting, blogging, landing pages, digital ads, time-saving, productivity, efficiency, marketing, seo (search engine optimization), online advertising, con',
                'auto_keyword' => 0,
                'created_at' => '2020-07-06 00:23:17',
                'updated_at' => '2020-09-14 03:13:07',
            ),
            1 => 
            array (
                'id' => 28,
                'priority' => NULL,
                'url' => '/blog',
                'info' => 'Blog page',
                'page_title' => 'AI Blog',
                'page_description' => 'Read our latest articles on AI related topics.',
                'page_keywords' => '',
                'auto_keyword' => 0,
                'created_at' => '2020-09-14 03:17:54',
                'updated_at' => '2020-09-14 03:17:54',
            ),
        ));
        
        
    }
}