@extends('backend.index')
@section('content')
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
            </li>
            <li class="breadcrumb-item active"><a href="{{ route('backend.roles') }}">{{ __('admin.user_groups') }}</a></li>
            <li class="breadcrumb-item active">{{ $role->name }}</li>
        </ol>
        <div class="row">
            <div class="col-lg-12">
                <ul class="nav nav-tabs nav-justified">
                    <li class="nav-item"><a href="#general" class="nav-link active show"  data-toggle="pill"><i class="fas fa-fw fa-cog"></i> {{ __('admin.general_settings') }}</a></li>
                    @if(request()->route('id') != 6)
                        <li class="nav-item"><a href="#blog" class="nav-link"  data-toggle="pill"><i class="fas fa-fw fa-newspaper"></i> {{ __('admin.blog') }}</a></li>
                        <li class="nav-item"><a href="#admin" class="nav-link" data-toggle="pill"><i class="fas fa-fw fa-lock"></i> {{ __('admin.administration_panel') }}</a></li>
                    @endif
                </ul>
                <form method="post" action="">
                    @csrf
                    <div class="tab-content mt-4" id="role-content">
                        <div id="general" class="tab-pane fade active show">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <div class="col-sm-8 ">
                                                    <label>{{ __('admin.group_name') }}</label>
                                                    <p class="small mb-0">{{ __('admin.group_name_description') }}</p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="group_name" value="{{ $role->name }}">
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <div class="col-sm-8 col-9 ">
                                                    <label class=" mb-0">{{ __('admin.allow_view_disabled') }}</label>
                                                    <p class="small mb-0">{{ __('admin.allow_view_disabled_desc') }}</p>
                                                </div>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[allow_offline]" value="1" @if(\Arr::get($role->permissions, 'allow_offline')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <div class="col-sm-8 col-9">
                                                    <label class=" mb-0">{{ __('admin.use_feedback') }}</label>
                                                    <p class="small mb-0">{{ __('admin.use_feedback_desc') }}</p>
                                                </div>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[option_feedback]" value="1" @if(\Arr::get($role->permissions, 'option_feedback')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            @if(request()->route('id') != 6)
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <div class="col-sm-8 ">
                                                        <label class=" mb-0">{{ __('admin.free_token_label') }}</label>
                                                        <p class="small mb-0">{{ __('admin.free_token_description') }}</p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="save_role[free_tokens]" value="{{ \Arr::get($role->permissions, 'free_tokens') }}">
                                                    </div>
                                                </div>
                                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                    <div class="col-sm-8 ">
                                                        <label class=" mb-0">{{ __('admin.max_chars_label') }}</label>
                                                        <p class="small mb-0">{{ __('admin.max_chars_description') }}</p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input type="text" class="form-control" name="save_role[option_max_info_chars]" value="{{ \Arr::get($role->permissions, 'option_max_info_chars') }}">
                                                    </div>
                                                </div>

                                            @endif
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <div class="col-sm-8 col-9">
                                                    <label class="mb-0">{{ __('admin.allow_edit') }}</label>
                                                    <p class="small mb-0">{{ __('admin.allow_edit_desc') }}</p>
                                                </div>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[option_stream]" value="1" @if(\Arr::get($role->permissions, 'option_stream')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="blog" class="tab-pane fade">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <div class="col-sm-8 col-9">
                                                    <label class="mb-0">{{ __('admin.available_categories') }}</label>
                                                    <p class="small mb-0">{{ __('admin.available_categories_desc') }}</p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select multiple="" class="form-control select2-active" name="save_role[blog_allow_view_categories][]">
                                                        <optgroup label="----- {{ __('admin.available_categories') }} -----">
                                                            {!! categorySelection(\Arr::get($role->permissions, 'blog_allow_view_categories')) !!}
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <div class="col-sm-8 col-9">
                                                    <label class=" mb-0">{{ __('admin.prohibited_categories') }}</label>
                                                    <p class="small mb-0">{{ __('admin.prohibited_categories_desc') }}</p>
                                                </div>
                                                <div class="col-sm-4">
                                                    <select multiple="" class="form-control select2-active" name="save_role[blog_prohibited_view_categories][]">
                                                        <optgroup label="----- {{ __('admin.prohibited_categories') }} -----">
                                                            {!! categorySelection(\Arr::get($role->permissions, 'blog_prohibited_view_categories')) !!}
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 mb-0">{{ __('admin.add_categories') }}
                                                    <p class="small mb-0">{{ __('admin.add_categories_desc') }}</p>
                                                </label>
                                                <div class="col-sm-4">
                                                    <select multiple="" class="form-control select2-active" name="save_role[blog_allow_add_categories][]">
                                                        <optgroup label="----- {{ __('admin.add_categories') }} -----">
                                                            {!! categorySelection(\Arr::get($role->permissions, 'blog_allow_add_categories')) !!}
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">@lang('admin.publish_news_verification')</label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch">
                                                        {!! makeCheckBox('save_role[blog_allow_public_directly]', \Arr::get($role->permissions, 'blog_allow_public_directly')) !!}
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">@lang('admin.trusted_sections')</label>
                                                <div class="col-sm-4 col-3">
                                                    <select multiple="" class="form-control select2-active" name="save_role[blog_trust_categories][]">
                                                        <optgroup label="@lang('admin.select_all')">
                                                            {!! categorySelection(\Arr::get($role->permissions, 'blog_trust_categories')) !!}
                                                        </optgroup>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">View hidden text
                                                    <p class="small mb-0">Allow user to view a text between [hide] [/hide] tags..</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[blog_allow_hide]" value="1" @if(\Arr::get($role->permissions, 'blog_allow_hide')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">Allow to vote in voting published in news
                                                    <p class="small mb-0">You can allow or deny this group to participate in the voting, which are added in the news.</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch">
                                                        {!! makeCheckBox('save_role[blog_allow_vote]', \Arr::get($role->permissions, 'blog_allow_vote')) !!}
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">Allow to use HTML when adding news
                                                    <p class="small mb-0">This option allows using HTML when adding news to the website. Please note, if you disable this option, and WYSIWYG editor is enabled in Script Settings.</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch">
                                                        {!! makeCheckBox('save_role[blog_allow_html]', \Arr::get($role->permissions, 'blog_allow_html')) !!}
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="comment" class="tab-pane fade">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">Allow to post comments
                                                    <p class="small mb-0">Allow the user to add comments on the site.</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[comment_allow]" value="1" @if(\Arr::get($role->permissions, 'comment_allow')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">Send comments for moderation
                                                    <p class="small mb-0">User’s comment will be published on the website only when it will be moderated by moderator or administrator.</p>
                                                    <p class="small text-danger">Warning! This module has been disabled in your script. For its full operation, it is necessary to include this module in the optimization section of your script.</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[comment_modc]" value="1" @if(\Arr::get($role->permissions, 'comment_modc')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <!--
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 mb-0">The maximum number of characters in the signature
                                                    <p class="small mb-0">Enter the maximum number of characters allowed in a user's signature. If you want to remove the restriction on the characters number, enter 0.</p>
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="save_role[comment_max_char]" value="{{ \Arr::get($role->permissions, 'comment_max_char') }}">
                                                </div>
                                            </div>
                                            -->
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">Allow to use clickable Links
                                                    <p class="small mb-0">You can allow or deny users to use clickable links in comments, profile or personal messages.</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[comment_url]" value="1" @if(\Arr::get($role->permissions, 'comment_url')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">Edit all the comments
                                                    <p class="small mb-0">Allow the user to edit any comments on his profile page, song page and playlist page.</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[comment_edit]" value="1" @if(\Arr::get($role->permissions, 'comment_edit')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">Delete profile, profile's song and profile's playlist comments
                                                    <p class="small mb-0">Allow the user to delete comments on his profile page, song page and playlist page.</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[option_comment_delete]" value="1" @if(\Arr::get($role->permissions, 'option_comment_delete')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 mb-0">Time limit for delete and edit comments
                                                    <p class="small mb-0">Set the time limit of time (in minutes) when user can edit or delete his/her comments if he/she is allowed to do so. To disable this limit, enter 0.	.</p>
                                                </label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" name="save_role[comment_day_limit_edit]" value="{{ \Arr::get($role->permissions, 'comment_day_limit_edit') }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(request()->route('id') != 6)
                        <div id="admin" class="tab-pane fade">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.allow_access_panel') }}
                                                    <p class="small mb-0">{{ __('admin.allow_access_panel_desc') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_access]" value="1" @if(\Arr::get($role->permissions, 'admin_access')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.allow_system_settings') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.allow_system_settings_desc') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_settings]" value="1" @if(\Arr::get($role->permissions, 'admin_settings')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.allow_email_template') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.email_template_access_warning') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_email]" value="1" @if(\Arr::get($role->permissions, 'admin_email')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.allow_seo_meta_tags') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.seo_meta_tags_access_warning') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_metatags]" value="1" @if(\Arr::get($role->permissions, 'admin_metatags')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>

                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.admin_languages') }}</label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_languages]" value="1" @if(\Arr::get($role->permissions, 'admin_languages')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.admin_roles') }}</label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_roles]" value="1" @if(\Arr::get($role->permissions, 'admin_roles')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">@lang('admin.allow_sitemap')
                                                    <p class="small text-danger mb-0">@lang('admin.sitemap_desc')</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_sitemap]" value="1" @if(\Arr::get($role->permissions, 'admin_sitemap')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.backup_management') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.backup_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch">
                                                        <input type="checkbox" name="save_role[admin_backup]" value="1" @if(\Arr::get($role->permissions, 'admin_backup')) checked="checked" @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.api_tester_management') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.api_tester_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch">
                                                        <input type="checkbox" name="save_role[admin_api_tester]" value="1" @if(\Arr::get($role->permissions, 'admin_api_tester')) checked="checked" @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.system_logs') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.system_logs_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch">
                                                        <input type="checkbox" name="save_role[admin_system_logs]" value="1" @if(\Arr::get($role->permissions, 'admin_system_logs')) checked="checked" @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.allow_scheduled_task') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.scheduled_task_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch">
                                                        <input type="checkbox" name="save_role[admin_scheduled]" value="1" @if(\Arr::get($role->permissions, 'admin_scheduled')) checked="checked" @endif>
                                                        <span class="slider round"></span>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.subscriptions') }}
                                                    <p class="small text-danger mb-0">{{ __('admin.subscriptions_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_subscriptions]" value="1" @if(\Arr::get($role->permissions, 'admin_subscriptions')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.categories') }}
                                                    <p class="small mb-0">{{ __('admin.categories_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_categories]" value="1" @if(\Arr::get($role->permissions, 'admin_categories')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.manage_post') }}
                                                    <p class="small mb-0">{{ __('admin.post_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_posts]" value="1" @if(\Arr::get($role->permissions, 'admin_posts')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.manage_users') }}
                                                    <p class="small mb-0">{{ __('admin.users_description') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_users]" value="1" @if(\Arr::get($role->permissions, 'admin_users')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                                <label class="col-sm-8 col-9 mb-0">{{ __('admin.allow_management_pages') }}
                                                    <p class="small mb-0">{{ __('admin.allow_management_pages_desc') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_pages]" value="1" @if(\Arr::get($role->permissions, 'admin_pages')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                            <div class="form-group row border-bottom mb-0 pt-3 pb-3 bg-danger">
                                                <label class="col-sm-8 col-9 mb-0 text-white">{{ __('admin.allow_access_terminal') }}
                                                    <p class="small mb-0">{{ __('admin.allow_access_terminal_desc') }}</p>
                                                </label>
                                                <div class="col-sm-4 col-3">
                                                    <label class="switch"><input type="checkbox" name="save_role[admin_terminal]" value="1" @if(\Arr::get($role->permissions, 'admin_terminal')) checked="checked" @endif><span class="slider round"></span></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="mt-3 clearfix">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-info">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
