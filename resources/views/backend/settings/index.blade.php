@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ config('settings.admin_path') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('admin.configure_script') }} ({{ __('admin.use_navigation') }})</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 py-3 border-left-info">
                <div class="card-body">
                    {{ __('admin.general_script_settings') }}
                </div>
            </div>
            <ul class="nav nav-tabs nav-justified">
                <li class="nav-item"><a class="nav-link active" href="#config" data-toggle="pill"><i class="fas fa-fw fa-cog"></i> {{ __('admin.general') }}</a></li>
                <li class="nav-item"><a href="#security" class="nav-link" data-toggle="pill"><i class="fas fa-fw fa-lock"></i> {{ __('admin.security') }}</a></li>
                <li class="nav-item"><a href="#upload" class="nav-link" data-toggle="pill"><i class="fas fa-fw fa-cloud"></i> {{ __('admin.storage') }}</a></li>
                <li class="nav-item"><a href="#post" class="nav-link" data-toggle="pill"><i class="fas fa-fw fa-newspaper"></i> {{ __('admin.blog') }}</a></li>
                <li class="nav-item"><a href="#email" class="nav-link" data-toggle="pill"><i class="fas fa-fw fa-mail-bulk"></i> {{ __('admin.email') }}</a></li>
                <li class="nav-item"><a href="#thirdparty" class="nav-link" data-toggle="pill"><i class="fas fa-fw fa-key"></i> {{ __('admin.authorization') }}</a></li>
                <li class="nav-item"><a href="#visitors" class="nav-link" data-toggle="pill"><i class="fas fa-fw fa-user"></i> {{ __('admin.visitors') }}</a></li>
            </ul>
            <form method="post" action="">
                @csrf
                <div class="tab-content mt-4" id="myTabContent">
                    <div id="config" class="tab-pane fade show active">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.openai_api_key_label') }}
                                                <p class="small mb-0">{{ __('admin.openai_api_key_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[open_ai_key]" value="{{ env('OPENAI_API_KEY') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.max_tokens_label') }}
                                                <p class="small mb-0">{{ __('admin.max_tokens_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[max_tokens]" value="{{ config('settings.max_tokens') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.image_size_label') }}
                                                <p class="small mb-0">{{ __('admin.image_size_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[image_size]" value="{{ config('settings.image_size') }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.website_url') }}
                                                <p class="small mb-0">{{ __('admin.website_url_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="utf-8" value="{{ env('APP_URL') }}" disabled>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.force_ssl') }}
                                                <p class="small mb-0">{{ __('admin.force_ssl_description') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[force_https]', config('settings.force_https')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.internal_html') }}
                                                <p class="small mb-0">{{ __('admin.internal_html_description') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[external_html]', config('settings.external_html')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.site_name') }}
                                                <p class="small mb-0">{{ __('admin.site_name_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[site_title]" value="{{ config('settings.site_title') }}" required>
                                            </div>
                                        </div>

                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.short_name_label') }}
                                                <p class="small mb-0">{{ __('admin.short_name_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[short_title]" value="{{ config('settings.short_title') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.currency_label') }}
                                                <p class="small mb-0">{!! trans('admin.currency_description', ['link' => '<a href="' . trans('admin.currency_link') . '" target="_blank">' . trans('admin.currency_link') . '</a>', 'api_link' => '<a href="' . trans('admin.currency_api_link') . '" target="_blank">' . trans('admin.currency_api_link') . '</a>']) !!}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(trans('currency'), "save_con[currency]", config('settings.currency') ) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.language_encoding_label') }}
                                                <p class="small mb-0">{{ __('admin.language_encoding_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="utf-8" name="save_con[charset]" value="{{ config('settings.charset') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.google_analytics_label') }}
                                                <p class="small mb-0">{{ __('admin.google_analytics_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="ex: UA-113452478-1" name="save_con[analytic_tracking_code]" value="{{ config('settings.analytic_tracking_code') }}">
                                            </div>
                                        </div>

                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.website_description') }}
                                                <p class="small mb-0">{{ __('admin.description_hint') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[description]" value="{{ config('settings.description') }}" required>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.meta_keywords') }}
                                                <p class="small mb-0">{{ __('admin.keywords_hint') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="2" name="save_con[keyword]" required>{{ config('settings.keyword') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.shutdown_website') }}
                                                <p class="small mb-0">{{ __('admin.shutdown_website_hint') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[site_offline]', config('settings.site_offline')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.site_shutdown_reason_label') }}
                                                <p class="small mb-0">{{ __('admin.site_shutdown_reason_help') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="6" name="save_con[offline_reason]">{{ config('settings.offline_reason') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.admin_dark_mode_label') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[admin_dark_mode]', config('settings.admin_dark_mode')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="security" class="tab-pane fade">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.file_of_admin_panel') }}
                                                <p class="small mb-0">{{ __('admin.admin_panel_location') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="admin_path" value="{{ env('APP_ADMIN_PATH', 'admin') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.method_of_authorization') }}
                                                <p class="small mb-0">{{ __('admin.extended_auth_method') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(array("0" => __('admin.standard_method'), "1" => __('admin.advanced_method')), "save_con[extra_login]", config('settings.extra_login') ) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.block_embedding_website') }}
                                                <p class="small mb-0">{{ __('admin.block_iframes_desc') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[block_iframes]', config('settings.block_iframes')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>


                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.ip_list_label') }}
                                                <p class="small mb-0">{{ __('admin.ip_list_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <textarea class="form-control" rows="4" name="save_con[admin_allowed_ip]">{{ config('settings.admin_allowed_ip') }}</textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.max_auth_label') }}
                                                <p class="small mb-0">{{ __('admin.max_auth_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[login_log]" value="{{ config('settings.login_log', 5) }}">
                                            </div>
                                        </div>


                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.time_out_label') }}
                                                <p class="small mb-0">{{ __('admin.time_out_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[login_ban_timeout]" value="{{ config('settings.login_ban_timeout', 20) }}">
                                            </div>
                                        </div>

                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.ip_change_monitor_label') }}
                                                <p class="small mb-0">{{ __('admin.ip_change_monitor_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(array("0" => "None", "1" => "Medium Level", "2" => "High Level"), "save_con[extra_login]", config('settings.log_hash') ) !!}
                                            </div>
                                        </div>

                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.reset_auth_key_label') }}
                                                <p class="small mb-0">{{ __('admin.reset_auth_key_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[log_hash]', config('settings.log_hash')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>



                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.enable_google_captcha') }}
                                                <p class="small mb-0">{{ __('admin.captcha_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[captcha]', config('settings.captcha')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.recaptcha_public_key') }}
                                                <p class="small mb-0">{{ __('admin.recaptcha_public_key_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[recaptcha_public_key]" value="{{ config('settings.recaptcha_public_key') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.recaptcha_secret_key') }}
                                                <p class="small mb-0">{{ __('admin.recaptcha_secret_key_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[recaptcha_secret_key]" value="{{ config('settings.recaptcha_secret_key') }}">
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="upload" class="tab-pane fade">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card mb-3">
                                            <div class="card-header">{{ __('admin.storage_settings') }}</div>
                                            <div class="card-body">
                                                <div class="form-group row mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">{{ __('admin.save_artwork_location') }}
                                                        <p class="small mb-0">{{ __('admin.select_location') }}</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        {!! makeDropDown($storage, "save_con[storage_artwork_location]", config('settings.storage_artwork_location', 'public') ) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card mb-3">
                                            <div class="card-header bg-warning text-white">{{ __('admin.amazon_s3_settings') }}</div>
                                            <div class="card-body">
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">{{ __('admin.bucket_name') }}
                                                        <p class="small mb-0">{{ __('admin.s3_bucket_description') }}</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" name="amazon_s3_bucket_name" value="{{ env('AWS_BUCKET') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">{{ __('admin.access_key_id') }}
                                                        <p class="small mb-0">{{ __('admin.access_key_description') }}</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" value="{{ env('AWS_ACCESS_KEY_ID') }}" name="amazon_s3_key_id">
                                                    </div>
                                                </div>
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">{{ __('admin.secret_key') }}
                                                        <p class="small mb-0">{{ __('admin.secret_key_description') }}</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" value="{{ env('AWS_SECRET_ACCESS_KEY') }}" name="amazon_s3_secret">
                                                    </div>
                                                </div>

                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">@lang('admin.amazon_s3_gateway')
                                                        <p class="small mb-0">@lang('admin.amazon_s3_gateway_info')</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" value="{{ env('AWS_DEFAULT_REGION') }}" name="amazon_s3_region" placeholder="@lang('admin.amazon_s3_region_placeholder')">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card mb-3">
                                            <div class="card-header bg-info text-white">@lang('admin.wasabi_storage_settings')</div>
                                            <div class="card-body">
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">@lang('admin.bucket_name_label')
                                                        <p class="small mb-0">@lang('admin.bucket_name_info')</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" name="wasabi_bucket_name" value="{{ env('WASABI_BUCKET') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">@lang('admin.access_key_id_label')
                                                        <p class="small mb-0">@lang('admin.access_key_id_info')</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" value="{{ env('WASABI_ACCESS_KEY_ID') }}" name="wasabi_key_id">
                                                    </div>
                                                </div>
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">@lang('admin.secret_access_key_label')
                                                        <p class="small mb-0">@lang('admin.secret_access_key_info')</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" value="{{ env('WASABI_SECRET_ACCESS_KEY') }}" name="wasabi_secret">
                                                    </div>
                                                </div>
                                                <div class="form-group row mb-0 pt-3 pb-3">
                                                    <label class="col-sm-8 mb-0">{{ __('admin.wasabi_gateway') }}
                                                        <p class="small mb-0">{{ __('admin.wasabi_gateway_description') }}</p>
                                                    </label>
                                                    <div class="col-sm-4">
                                                        <input class="form-control" value="{{ env('WASABI_DEFAULT_REGION') }}" name="wasabi_region" placeholder="{{ __('admin.wasabi_region_placeholder') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="post" class="tab-pane fade">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.num_post_per_page') }}
                                                <p class="small mb-0">{{ __('admin.num_post_per_page_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[num_post_per_page]" value="{{ config('settings.num_post_per_page') }}">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.post_restriction') }}
                                                <p class="small mb-0">{{ __('admin.post_restriction_description') }}</p></label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ config('settings.post_restriction') }}" name="save_con[post_restriction]">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.post_time_format') }}
                                                <p class="small mb-0">{{ __('admin.post_time_format_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ config('settings.post_time_format') }}" name="save_con[post_time_format]">
                                            </div>

                                        </div>

                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.show_post_pages_navigation') }}
                                                <p class="small mb-0">{{ __('admin.post_pages_navigation_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(array("0" => __('admin.disabled'), "1" => __('admin.full_page_number'), "2" => __('admin.older_and_newer')), "save_con[post_navigation]", config('settings.post_navigation') ) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.sort_order_for_posts') }}
                                                <p class="small mb-0">{{ __('admin.sort_order_for_posts_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(array("0" => __('admin.descending'), "1" => __('admin.ascending')), "save_con[post_sort_order]", config('settings.post_sort_order') ) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.sort_criterion_in_a_catalog') }}
                                                <p class="small mb-0">{{ __('admin.sort_criterion_in_a_catalog_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(array("0" => __('admin.by_publication_date'), "1" => __('admin.by_views'), "2" => __('admin.alphabetical'), "3" => __('admin.by_number_of_comments')), "save_con[post_sort_order]", config('settings.post_sort_order') ) !!}
                                            </div>
                                        </div>


                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.auto_meta_tags') }}
                                                <p class="small mb-0">{{ __('admin.auto_meta_tags_description') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[post_auto_meta]', config('settings.post_auto_meta')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.show_post_without_date') }}
                                                <p class="small mb-0">{{ __('admin.show_post_without_date_description') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[post_without_scheduling]', config('settings.post_without_scheduling')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.send_email_notification') }}
                                                <p class="small mb-0">{{ __('admin.send_email_notification_description') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[post_email_notification]', config('settings.post_email_notification')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>



                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.post_show_sub') }}
                                                <p class="small mb-0">{{ __('admin.post_show_sub_description') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[post_show_sub]', config('settings.post_show_sub')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.image_max_up_side') }}
                                                <p class="small mb-0">{!! __('admin.image_max_up_side_description') !!}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[image_max_up_side]" value="{{ config('settings.image_max_up_side', 0) }}">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.default_image_settings') }}
                                                <p class="small mb-0">{{ __('admin.default_image_settings_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(array(
                                                    "0" => __('admin.default_image_settings_option1'),
                                                    "1" => __('admin.default_image_settings_option2'),
                                                    "2" => __('admin.default_image_settings_option3')
                                                ), "save_con[extra_login]", config('settings.log_hash')) !!}
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="email" class="tab-pane fade">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.admin_email_label') }}
                                                <p class="small mb-0">{{ __('admin.admin_email_desc') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ config('settings.admin_mail', __('admin.admin_email_default')) }}" name="save_con[admin_mail]">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.email_title_label') }}
                                                <p class="small mb-0">{{ __('admin.email_title_desc') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ config('settings.mail_title') }}" name="save_con[mail_title]">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.mail_driver_label') }}
                                                <p class="small mb-0">{{ __('admin.mail_driver_desc') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown( array("sendmail" => "PHP Mail()", "smtp" => "SMTP"), "mail_driver", env('MAIL_MAILER', 'smtp') ) !!}
                                            </div>
                                        </div>



                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.mail_host') }}
                                                <p class="small mb-0">{{ __('admin.mail_host_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ env('MAIL_HOST', 'localhost') }}" name="mail_host">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.mail_port') }}
                                                <p class="small mb-0">{{ __('admin.mail_port_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" placeholder="25" value="{{ env('MAIL_PORT') }}" name="mail_port">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.mail_username') }}
                                                <p class="small mb-0">{{ __('admin.mail_username_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ env('MAIL_USERNAME') }}" name="mail_username">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.mail_password') }}
                                                <p class="small mb-0">{{ __('admin.mail_password_description') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ env('MAIL_PASSWORD') }}" name="mail_password">
                                            </div>
                                        </div>


                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">@lang('admin.mail_secure.label')
                                                <p class="small mb-0">@lang('admin.mail_secure.description')</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown( array("ssl" => "SSL", "tls" => "TLS"), "mail_encryption", env('MAIL_ENCRYPTION') ) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">@lang('admin.enable_mailchimp_subscribe.label')
                                                <p class="small mb-0">@lang('admin.enable_mailchimp_subscribe.description', ['text-info' => '<span class="text-info">', 'text-info-close' => '</span>'])</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">
                                                    {!! makeCheckBox('save_con[mailchimp]', config('settings.mailchimp')) !!}
                                                    <span class="slider round"></span>
                                                </label>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="thirdparty" class="tab-pane fade">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 col-9 mb-0">{{ __('admin.enable_facebook_authorization') }}
                                        <p class="small mb-0">{{ __('admin.enable_facebook_authorization_description') }}</p>
                                    </label>
                                    <div class="col-sm-4 col-3">
                                        <label class="switch">{!! makeCheckBox('save_con[facebook_login]', config('settings.facebook_login')) !!}<span class="slider round"></span></label>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.facebook_app_id') }}
                                        <p class="small mb-0">{{ __('admin.facebook_app_id_description') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="facebook_app_id" value="{{ env('FACEBOOK_APP_ID') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.facebook_app_secret') }}
                                        <p class="small mb-0">{{ __('admin.facebook_app_secret_description') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="facebook_app_secret" value="{{ env('FACEBOOK_APP_SECRET') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.facebook_app_redirect') }}
                                        <p class="small mb-0">{{ __('admin.facebook_app_redirect_description') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="facebook_app_callback_url" value="{{ env('FACEBOOK_APP_CALLBACK_URL') ? env('FACEBOOK_APP_CALLBACK_URL') : route('frontend.auth.login.socialite.callback', ['service' => 'facebook']) }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 col-9 mb-0">{{ __('admin.google_auth') }}
                                        <p class="small mb-0">{{ __('admin.google_auth_desc') }}</p>
                                    </label>
                                    <div class="col-sm-4 col-3">
                                        <label class="switch">{!! makeCheckBox('save_con[google_login]', config('settings.google_login')) !!}<span class="slider round"></span></label>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.google_client_id') }}
                                        <p class="small mb-0">{{ __('admin.google_client_id_desc') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="google_client_id" value="{{ env('GOOGLE_CLIENT_ID') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.google_client_secret') }}
                                        <p class="small mb-0">{{ __('admin.google_client_secret_desc') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="google_client_secret" value="{{ env('GOOGLE_CLIENT_SECRET') }}">
                                    </div>
                                </div>


                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.google_oauth_redirect') }}
                                        <p class="small mb-0">{{ __('admin.google_oauth_redirect_small') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="google_app_callback_url" value="{{ env('GOOGLE_CLIENT_CALLBACK_URL') ? env('GOOGLE_CLIENT_CALLBACK_URL') : route('frontend.auth.login.socialite.callback', ['service' => 'google']) }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 col-9 mb-0">{{ __('admin.enable_twitter_auth') }}
                                        <p class="small mb-0">{{ __('admin.enable_twitter_auth_small') }}</p>
                                    </label>
                                    <div class="col-sm-4 col-3">
                                        <label class="switch">{!! makeCheckBox('save_con[twitter_login]', config('settings.twitter_login')) !!}<span class="slider round"></span></label>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.twitter_app_id') }}
                                        <p class="small mb-0">{{ __('admin.twitter_app_id_small') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="twitter_app_id" value="{{ env('TWITTER_APP_ID') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.twitter_app_secret') }}
                                        <p class="small mb-0">{{ __('admin.twitter_app_secret_small') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="twitter_app_secret" value="{{ env('TWITTER_APP_SECRET') }}">
                                    </div>
                                </div>


                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 col-9 mb-0">{{ __('admin.enable_authorization_using_apple') }}
                                        <p class="small mb-0">{{ __('admin.enable_or_disable_using_apple_support') }}</p>
                                    </label>
                                    <div class="col-sm-4 col-3">
                                        <label class="switch">{!! makeCheckBox('save_con[apple_login]', config('settings.apple_login')) !!}<span class="slider round"></span></label>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.apple_client_id') }}
                                        <p class="small mb-0">{{ __('admin.specify_application_id_in_apple_network') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="apple_app_id" value="{{ env('SIGN_IN_WITH_APPLE_CLIENT_ID') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.apple_service_secret') }}
                                        <p class="small mb-0">{{ __('admin.specify_secure_key_of_application_in_apple_network') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="apple_app_secret" value="{{ env('SIGN_IN_WITH_APPLE_CLIENT_SECRET') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.apple_app_redirect_url') }}
                                        <p class="small mb-0">{{ __('admin.this_should_be_your_site_url') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="apple_app_callback_url" value="{{ env('SIGN_IN_WITH_APPLE_REDIRECT') ? env('SIGN_IN_WITH_APPLE_REDIRECT') : route('frontend.auth.login.socialite.callback', ['service' => 'apple']) }}">
                                    </div>
                                </div>



                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 col-9 mb-0">{{ __('admin.enable_authorization_using_discord') }}
                                        <p class="small mb-0">{{ __('admin.enable_or_disable_authorization_using_discord') }}</p>
                                    </label>
                                    <div class="col-sm-4 col-3">
                                        <label class="switch">{!! makeCheckBox('save_con[discord_login]', config('settings.discord_login')) !!}<span class="slider round"></span></label>
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.discord_client_id') }}
                                        <p class="small mb-0">{{ __('admin.specify_your_application_id_in_discord_network') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="discord_app_id" value="{{ env('DISCORD_CLIENT_ID') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.discord_client_service_secret') }}
                                        <p class="small mb-0">{{ __('admin.specify_the_secure_key_of_your_application_in_discord_network') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="discord_app_secret" value="{{ env('DISCORD_CLIENT_SECRET') }}">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.discord_app_redirect_url') }}
                                        <p class="small mb-0">{{ __('admin.this_should_be_your_site_url') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="discord_callback_url" value="{{ env('DISCORD_REDIRECT') ? env('DISCORD_REDIRECT') : route('frontend.auth.login.socialite.callback', ['service' => 'discord']) }}">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div id="visitors" class="tab-pane fade">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.register_new_users') }}
                                                <p class="small mb-0">{{ __('admin.select_group') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeRolesDropDown("save_con[default_usergroup]", config('settings.default_usergroup', 5)) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.registration_method') }}
                                                <p class="small mb-0">{{ __('admin.letter_activation') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                {!! makeDropDown(array("0" => "Simplified", "1" => "Advanced"), "save_con[registration_method]", config('settings.registration_method')) !!}
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">{{ __('admin.allow_login_social') }}
                                                <p class="small mb-0">{{ __('admin.social_login_settings') }}</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">{!! makeCheckBox('save_con[social_login]', config('settings.social_login')) !!}<span class="slider round"></span></label>
                                            </div>
                                        </div>





                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">@lang('admin.disable_registration')
                                                <p class="small mb-0">@lang('admin.disable_registration_description')</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">{!! makeCheckBox('save_con[disable_register]', config('settings.disable_register')) !!}<span class="slider round"></span></label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 col-9 mb-0">@lang('admin.security_code')
                                                <p class="small mb-0">@lang('admin.security_code_description')</p>
                                            </label>
                                            <div class="col-sm-4 col-3">
                                                <label class="switch">{!! makeCheckBox('save_con[register_captcha]', config('settings.register_captcha')) !!}<span class="slider round"></span></label>
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">@lang('admin.max_registered_users')
                                                <p class="small mb-0">@lang('admin.max_registered_users_description')</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ config('settings.users_max') }}" name="save_con[users_max]">
                                            </div>
                                        </div>



                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.automatically_delete_users') }}
                                                <p class="small mb-0">{{ __('admin.days_missing_on_website') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" value="{{ config('settings.delete_inactive_user') }}" name="save_con[delete_inactive_user]">
                                            </div>
                                        </div>
                                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                            <label class="col-sm-8 mb-0">{{ __('admin.minimum_avatar_size') }}
                                                <p class="small mb-0">{{ __('admin.enter_minimum_avatar_size') }}</p>
                                            </label>
                                            <div class="col-sm-4">
                                                <input class="form-control" name="save_con[image_avatar_size]" value="{{ config('settings.image_avatar_size', 300) }}">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 clearfix">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="reset" class="btn btn-info">Reset</button>
                </div>
            </form>
        </div>
    </div>
@endsection
