<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrator',
                'permissions' => '{"allow_offline":"1","option_feedback":"1","free_tokens":"9500","option_max_info_chars":"300","option_stream":"1","blog_allow_public_directly":"1","blog_allow_hide":"1","blog_allow_vote":"1","blog_allow_html":"1","blog_allow_public_home":"1","blog_allow_public_fixed":"1","blog_allow_upload_images":"1","blog_allow_upload_files":"1","blog_num_files_allow":"5","blog_day_edit_limit":"5","blog_upload_extensions":"5","blog_upload_size":"1024","blog_download_speed":"100","blog_flood":"60","blog_news_per_day":"5","comment_allow":"1","comment_url":"1","comment_edit":"1","option_comment_delete":"1","comment_day_limit_edit":"0","admin_access":"1","admin_settings":"1","admin_email":"1","admin_metatags":"1","admin_languages":"1","admin_roles":"1","admin_media_manager":"1","admin_sitemap":"1","admin_backup":"1","admin_api_tester":"1","admin_system_logs":"1","admin_scheduled":"1","admin_subscriptions":"1","admin_categories":"1","admin_posts":"1","admin_users":"1","admin_pages":"1","admin_terminal":"1","group_name":"Administrator"}',
                'created_at' => '2023-02-13 06:14:34',
                'updated_at' => '2023-02-17 14:38:15',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Moderator',
                'permissions' => '{"allow_offline":"1","option_feedback":"1","free_tokens":null,"option_max_info_chars":"160","option_stream":"1","blog_allow_public_directly":"1","blog_allow_hide":"1","blog_allow_vote":"1","blog_allow_html":"1","blog_allow_public_home":"1","blog_allow_public_fixed":"1","blog_allow_upload_images":"1","blog_allow_upload_files":"1","blog_num_files_allow":"5","blog_day_edit_limit":"5","blog_upload_extensions":"5","blog_upload_size":"1024","blog_download":"1","blog_download_speed":"100","blog_flood":"60","blog_news_per_day":"5","comment_allow":"1","comment_url":"1","comment_edit":"1","option_comment_delete":"1","comment_day_limit_edit":"0","admin_access":"1","admin_categories":"1","admin_posts":"1","admin_users":"1","admin_pages":"1","group_name":"Moderator"}',
                'created_at' => NULL,
                'updated_at' => '2023-02-17 14:38:32',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Blogger',
                'permissions' => '{"option_feedback":"1","free_tokens":null,"option_max_info_chars":"180","option_stream":"1","blog_allow_public_directly":"1","blog_allow_hide":"1","blog_allow_vote":"1","blog_allow_html":"1","blog_allow_public_home":"1","blog_allow_public_fixed":"1","blog_allow_upload_images":"1","blog_allow_upload_files":"1","blog_num_files_allow":"5","blog_day_edit_limit":"5","blog_upload_extensions":"5","blog_upload_size":"1024","blog_download":"1","blog_download_speed":"100","blog_flood":"60","blog_news_per_day":"5","comment_allow":"1","comment_url":"1","comment_edit":"1","option_comment_delete":"1","comment_day_limit_edit":"0","group_name":"Blogger"}',
                'created_at' => '2023-02-13 06:14:34',
                'updated_at' => '2023-02-17 14:38:35',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Member',
                'permissions' => '{"ad_support":"1","option_feedback":"1","free_tokens":"1500","option_max_info_chars":"180","option_stream":"1","blog_allow_public_directly":"0","blog_allow_hide":"1","blog_allow_vote":"1","blog_allow_html":"1","blog_allow_public_home":"1","blog_allow_public_fixed":"1","blog_allow_upload_images":"1","blog_allow_upload_files":"1","blog_num_files_allow":"5","blog_day_edit_limit":"5","blog_upload_extensions":"5","blog_upload_size":"1024","blog_download":"1","blog_download_speed":"100","blog_flood":"60","blog_news_per_day":"5","comment_allow":"1","comment_url":"1","comment_day_limit_edit":"5","group_name":"Member"}',
                'created_at' => '2023-02-13 06:14:34',
                'updated_at' => '2023-02-17 14:38:39',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'Guest',
                'permissions' => '{"ad_support":"1","option_stream":"1","option_download_speed":"200","artist_num_files_allow":null,"artist_day_edit_limit":null,"artist_files_upload_each_time":null,"artist_files_each_album":null,"artist_max_songs":null,"artist_max_albums":null,"user_max_playlists":null,"user_max_playlist_songs":null,"artist_podcast_max_episodes":null,"artist_podcast_day_edit_limit":null,"artist_max_podcasts":null,"monetization_sale_cut":null,"monetization_song_min_price":null,"monetization_song_max_price":null,"monetization_album_min_price":null,"monetization_album_max_price":null,"monetization_streaming_rate":null,"monetization_paypal_min_withdraw":null,"monetization_bank_min_withdraw":null,"blog_allow_view_categories":["3","5"],"blog_prohibited_view_categories":["4","5"],"blog_allow_add_categories":["2","3","4","5","6","7"],"blog_allow_public_directly":"1","blog_trust_categories":["4"],"blog_allow_vote":"0","blog_allow_html":"0","blog_allow_public_home":"0","blog_allow_public_fixed":"0","blog_allow_upload_images":"0","blog_allow_upload_files":"0","blog_num_files_allow":"5","blog_day_edit_limit":"5","blog_upload_extensions":"5","blog_upload_size":"1024","blog_download_speed":"100","blog_flood":"300","blog_news_per_day":"5","comment_day_limit_edit":"0","group_name":"Guest"}',
                'created_at' => '2023-02-13 06:14:34',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}