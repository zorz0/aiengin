@extends('backend.index')
@section('content')
    <script>
        var revenueSourcesLabel = [@foreach($dashboard->plans as $plan)"{{ $plan->title }}",@endforeach];
        var revenueSourcesLabelData  = [@foreach($dashboard->plans as $plan) "{{ DB::table('subscriptions')->where('service_id', $plan->id)->where('payment_status', 1)->count() }}", @endforeach]
        var subscriptionOverviewChartLabel = @json($dashboard->orders_data->period);
        var subscriptionOverviewChartData = @json($dashboard->orders_data->earnings);
        var currencyLabel = '{{ __('symbol.' . config('settings.currency', 'USD')) }}';
        var updateCheckerUrl = '{{ route('backend.dashboard.check.for.update') }}';

    </script>
    <div class="row">
        <div class="col-12">
            @if($dashboard->server->max_execution_time < 300)
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ __('admin.max_execution_time_err') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(! function_exists( 'simplexml_load_file' ))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('admin.php_extension_not_installed', ['extension' => 'simplexml_load_file']) }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('admin.close_button') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
            @endif
                @if(! extension_loaded('exif'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('admin.exif_extension_not_installed', ['extension' => 'exif']) }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('admin.close_button') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if(! extension_loaded('fileinfo'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('admin.fileinfo_extension_not_installed', ['extension' => 'fileinfo']) }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('admin.close_button') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                @if($dashboard->server->memory_limit < 32)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ __('admin.memory_limit_too_low', ['value' => '32MB', 'currentValue' => $dashboard->server->memory_limit]) }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="{{ __('admin.close_button') }}">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
        </div>
        @if(\App\Models\Role::getValue('admin_users'))
            <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
                <div class="card text-white bg-gradient-info o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-users"></i>
                        </div>
                        <div class="mr-5 h2">{{ $dashboard->statistics->total_users }} Users</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('backend.users') }}">
                        <span class="float-left">{{ __('admin.view_details') }}</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                    </a>
                </div>
            </div>
        @endif
        @if(\App\Models\Role::getValue('admin_subscriptions'))
            <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
                <div class="card text-white bg-secondary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-shopping-cart"></i>
                        </div>
                        <div class="mr-5 h2">{{ $dashboard->statistics->total_subscriptions }} Subscriptions</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('backend.subscriptions') }}">
                        <span class="float-left">{{ __('admin.view_details') }}</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                    </a>
                </div>
            </div>
        @endif
        @if(\App\Models\Role::getValue('admin_posts'))
            <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
                <div class="card text-white bg-gradient-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fa fa-fw fa-edit"></i>
                        </div>
                        <div class="mr-5 h2">{{ $dashboard->statistics->total_posts }} Posts</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="{{ route('backend.posts') }}">
                        <span class="float-left">{{ __('admin.view_details') }}</span>
                        <span class="float-right">
                        <i class="fa fa-angle-right"></i>
                    </span>
                    </a>
                </div>
            </div>
        @endif
        <div class="col-xl-3 col-lg-6 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                    </div>
                    <div class="mr-5 h2">{{ $stats->revenue }} {{ config('settings.currency', 'USD') }}</div>
                    <p class="float-left mb-0">{{ __('admin.total_revenue') }}</p>
                </div>
                <a class="card-footer text-white clearfix small z-1" href="{{ route('backend.reports') }}">
                    <span class="float-left">{{ __('admin.view_details') }}</span>
                    <span class="float-right">
                    <i class="fa fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>
    </div>
    <div id="update-alert" class="alert alert-info d-none" data-version="{{ env('APP_VERSION') }}">
        <p class="text-danger"><strong>{{ __('admin.update_alert_title', ['version' => env('APP_VERSION')]) }}</strong></p>
        <p>{{ __('admin.update_alert_new_version') }} <strong class="text-success new-version"></strong></p>
        <p class="beta-alert text-danger d-none"><strong>{{ __('admin.update_alert_beta_warning') }}</strong></p>
        <p>{{ __('admin.update_alert_upgrade_link') }} <a href="{{ route('backend.upgrade') }}" class="badge badge-pill badge-success">{{ __('admin.update_alert_button') }}</a></p>
        <p>{{ __('admin.update_alert_view_info') }} <a href="https://codecanyon.net/item/aiengine-music-social-networking/28641149" class="text-primary" target="_blank">AI Engine <strong class="new-version"></strong></a></p>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><i class="fa fa-tools"></i> {{ __('admin.quick_access') }}</h6>
        </div>
        <div class="card-body">
            <div class="row">
                @if(\App\Models\Role::getValue('admin_users'))
                    <div class="col-xl-6 col-sm-6 mb-3">
                        <a class="quick" href="{{ route('backend.users') }}">
                            <div class="media">
                                <img src="{{ asset('backend/images/users.svg') }}">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ __('admin.edit_users_title') }}</h5>
                                    {{ __('admin.edit_users_description') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if(\App\Models\Role::getValue('admin_settings'))
                    <div class="col-xl-6 col-sm-6 mb-3">
                        <a class="quick" href="{{ route('backend.settings') }}">
                            <div class="media">
                                <img src="{{ asset('backend/images/settings.svg') }}">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ __('lang.system_settings') }}</h5>
                                    {{ __('lang.system_settings_description') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if(\App\Models\Role::getValue('admin_pages'))

                    <div class="col-xl-6 col-sm-6 mb-3">
                        <a class="quick" href="{{ route('backend.pages') }}">
                            <div class="media">
                                <img src="{{ asset('backend/images/pages.svg') }}">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ __('admin.page_tool') }}</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if(\App\Models\Role::getValue('admin_users'))
                    <div class="col-xl-6 col-sm-6 mb-3">
                        <a class="quick" href="{{ route('backend.users.edit', ['id' => auth()->user()->id]) }}">
                            <div class="media">
                                <img src="{{ asset('backend/images/profile.svg') }}">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ __('admin.setting_tool') }}</h5>
                                    {{ __('admin.setting_desc') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if(\App\Models\Role::getValue('admin_roles'))

                    <div class="col-xl-6 col-sm-6 mb-3">
                        <a class="quick" href="{{ route('backend.roles') }}">
                            <div class="media">
                                <img src="{{ asset('backend/images/group.svg') }}">
                                <div class="media-body">
                                    <h5 class="mt-0">@lang('admin.configure_user_groups')</h5>
                                    <p>@lang('admin.configure_user_groups_description')</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if(\App\Models\Role::getValue('admin_email'))

                    <div class="col-xl-6 col-sm-6 mb-3">
                        <a class="quick" href="{{ route('backend.email') }}">
                            <div class="media">
                                <img src="{{ asset('backend/images/email.svg') }}">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ __('admin.email_templates') }}</h5>
                                    {{ __('admin.email_templates_description') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @if(\App\Models\Role::getValue('admin_metatags'))
                    <div class="col-xl-6 col-sm-6 mb-3">
                        <a class="quick" href="{{ route('backend.metatags') }}">
                            <div class="media">
                                <img src="{{ asset('backend/images/seo.svg') }}">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ __('admin.titles_descriptions_metatags') }}</h5>
                                    {{ __('admin.titles_descriptions_metatags_description') }}
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    @if(\App\Models\Role::getValue('admin_subscriptions'))
        <div class="row">
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-money-check-alt"></i> {{ __('backend.earnings_overview') }}</h6>
                        <a href="{{ route('backend.reports') }}" class="m-0 font-weight-bold text-primary h6 float-right"><i class="fas fa-chart-bar"></i> {{ __('backend.get_full_report') }}</a>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="subscriptionOverviewChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.revenue_sources_title') }}</h6>
                    </div>
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="revenueSources"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="row">
        @if(\App\Models\Role::getValue('admin_subscriptions'))
            <div class="col-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-shopping-cart"></i> @lang('admin.recent_orders')</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>{{ __('admin.customer') }}</th>
                                <th>{{ __('admin.status') }}</th>
                                <th class="desktop">{{ __('admin.plan') }}</th>
                                <th class="desktop">{{ __('admin.billing') }}</th>
                                <th>{{ __('admin.amount') }}</th>
                                <th class="desktop" width="120px">{{ __('admin.created') }}</th>
                            </tr>
                            </thead>
                            @foreach ($dashboard->subscriptions as $index => $order )
                                @if($order->user)
                                    <tr>
                                        <td><a href="{{ route('backend.users.edit', ['id' => $order->user->id]) }}">{{ $order->user->name }}</a></td>
                                        <td>
                                            @if(\Carbon\Carbon::parse($order->trial_end)->gt(\Carbon\Carbon::now()))
                                                <span class="badge badge-info">Trial ends {{ \Carbon\Carbon::parse($order->trial_end)->format('F j') }}</span>
                                            @elseif(\Carbon\Carbon::parse($order->next_billing_date)->gt(\Carbon\Carbon::now()))
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">in-Active</span>
                                            @endif
                                        </td>
                                        <td class="desktop">
                                            @if(isset($order->service))
                                                <a href="{{ route('backend.services.edit', ['id' => $order->service->id]) }}">{{ $order->service->title }}</a>
                                            @endif
                                        </td>
                                        <td><span class="badge badge-secondary">Auto</span></td>
                                        <td>{{ __('symbol.' . $order->currency) }}{{ number_format($order->amount) }}</td>
                                        <td class="desktop">{{ timeElapsedString($order->created_at) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        @endif
        @if(\App\Models\Role::getValue('admin_users'))
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> {{ __('admin.recent_users') }}</h6>
                    </div>
                    <div class="card-body users">
                        @foreach($dashboard->recentUsers as $user)
                            <div class="media border-bottom pb-2 pt-2">
                                <div class="artwork">
                                    <img src="{{ $user->artwork_url ?  $user->artwork_url : url('common/default/user.svg') }}" class="media-object rounded-circle">
                                </div>
                                <div class="media-body ml-3">
                                    <h6 class="media-heading"><a href="{{ route('backend.users.edit', ['id' => $user->id]) }}">{{ $user->name }}</a></h6>
                                    <p class="mb-0">{{ $user->email }}  <span class="text-secondary float-right">{{ timeElapsedString($user->created_at) }}</span></p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
        @if(\App\Models\Role::getValue('admin_posts'))
            <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-newspaper"></i> Recent posts</h6>
                    </div>
                    <div class="card-body">
                        @foreach($dashboard->recentPosts as $post)
                            <div class="media border-bottom pb-2 pt-2">
                                <div class="media-body">
                                    <h6 class="media-heading"><a href="{{ route('backend.posts.edit', ['id' => $post->id]) }}">{{ $post->title }}</a></h6>
                                    @if(isset($post->user))
                                        <p class="mb-0">by <a href="{{ $post->user->permalink_url }}">{{ $post->user->name }}</a> <span class="text-secondary float-right">{{ timeElapsedString($post->created_at) }}</span></p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    @if(\App\Models\Role::getValue('admin_settings'))
        <div class="card mt-4">
            <div class="card-header p-0">
                <ul class="nav" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true"><i class="fas fa-chart-line"></i> {{ __('admin.operation_status') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false"><i class="fas fa-cog"></i> {{ __('admin.system_auto_check') }}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <td>{{ __('admin.operation_status') }}</td>
                                <td>{!! $dashboard->statistics->system_status !!}</td>
                            </tr>
                            <tr>
                                <td>{{ __('admin.site_url') }}</td>
                                <td>{{ $dashboard->statistics->site_url }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('admin.total_posts') }}</td>
                                <td>{{ $dashboard->statistics->total_posts }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('admin.awaiting_posts') }}</td>
                                <td>{{ $dashboard->statistics->awaiting_posts }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('admin.registered_users') }}</td>
                                <td>{{ $dashboard->statistics->total_users }}</td>
                            </tr>
                            <tr>
                                <td>{{ __('admin.banned_users') }}</td>
                                <td>{{ $dashboard->statistics->banned_users }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <table class="table table-striped">
                            <tbody>
                            {!! $dashboard->information  !!}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection
