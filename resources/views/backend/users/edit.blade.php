@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ route('backend.users') }}">Users</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@lang('admin.edit_user') <strong>{{ $user->name }}</strong></h6>
                </div>
                <div class="card-body">
                    <form role="form" action="" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.name') }}</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="name" value="{{ $user->name }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.avatar') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group col-xs-12">
                                    <input type="file" name="artwork" class="file-selector" accept="image/*">
                                    <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                                    <input type="text" class="form-control input-lg" disabled placeholder="{{ __('admin.upload_image') }}">
                                    <span class="input-group-btn"><button class="browse btn btn-primary input-lg" type="button">><i class="fas fa-fw fa-file"></i> {{ __('admin.browse_btn') }}</button></span>
                                </div>
                                <small id="emailHelp" class="form-text text-muted">{{ __('admin.min_width_height') }}</small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.email') }}</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="email"  value="{{ $user->email }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.do_not_receive_emails') }}</label>
                            <div class="col-sm-8 col-3">
                                <label class="switch"><input type="checkbox" name="blockEmail"><span class="slider round"></span></label>
                            </div>
                        </div>


                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.password_label') }}</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="password">
                            </div>
                        </div>

                        @if(isset($user->ban->id))
                            <div class="alert alert-danger">
                                <h5>{{ __('admin.ban_alert_title') }}</h5>
                                <p>{{ __('admin.ban_alert_message') }}</p>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.banned_label') }}</label>
                            <div class="col-sm-8 col-3">
                                <label class="switch">
                                    {!! makeCheckBox('banned', isset($user->ban->id) ?  $user->ban->id : 0) !!}
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.ban_end_time_label') }}</label>
                            <div class="col-sm-8 col-3">
                                <input class="form-control datepicker-no-mask" name="ban_end_at" value="{{ isset($user->ban->id) ? \Carbon\Carbon::parse(($user->ban->end_at))->format('Y/m/d H:i') : '' }}"  autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.ban_reason_label') }}</label>
                            <div class="col-sm-8 col-3">
                                <textarea class="form-control editor" rows="2" name="ban_reason">{{ isset($user->ban->id) ? $user->ban->reason : ''}}</textarea>
                            </div>
                        </div>
                        @if($user->group && \App\Models\Role::getValue('admin_roles'))
                            <div class="form-group row">
                                <label class="col-sm-4 col-form-label">@lang('admin.group_label')</label>
                                <div class="col-sm-8">
                                    {!! makeRolesDropDown('role', $user->group ? $user->group->role_id : 0, 'required') !!}
                                </div>
                            </div>
                        @endif

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">@lang('admin.remove_avatar_label')</label>
                            <div class="col-sm-8 col-3">
                                <label class="switch"><input type="checkbox" name="removeArtwork"><span class="slider round"></span></label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">@lang('admin.delete_comments_label')</label>
                            <div class="col-sm-8">
                                <label class="switch"><input type="checkbox" name="deleteComments"><span class="slider round"></span></label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">@lang('admin.about_me_label')</label>
                            <div class="col-sm-8">
                                <textarea class="form-control editor" rows="2" name="about"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="doEdit" value="true">

                        <button type="submit" class="btn btn-primary">@lang('admin.submit_button')</button>
                        <button type="reset" class="btn btn-info">@lang('admin.reset_button')</button>

                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-5 main-section text-center">
            <div class="row">
                <div class="col-lg-12 col-sm-12 col-12 profile-header"></div>
            </div>
            <div class="row user-detail">
                <div class="col-lg-12 col-sm-12 col-12">
                    <img src="{{ $user->artwork_url ?  $user->artwork_url : url('common/default/user.svg')}}" class="rounded-circle img-thumbnail">
                    <h5>{{ $user->name }}</h5>
                    <p>{{ $user->email }}</p>
                    <table class="mt-4 table table-striped">
                        <tr>
                            <td>E-Mail</td>
                            <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        </tr>
                        <tr>
                            <td>Registered</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Subscription</td>
                            <td>
                                @if($user->subscription)
                                    <a class="badge badge-success badge-pill" href="{{ route('backend.services.edit', ['id' => $user->subscription->service->id]) }}">{{ $user->subscription->service->title }}</a>
                                @else
                                    None
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Recent Activity</td>
                            <td>{{ $user->last_activity }}</td>
                        </tr>
                        <tr>
                            <td>IP</td>
                            <td>{{ $user->logged_ip }}</td>
                        </tr>
                        @if($user->group &&  \App\Models\Role::getValue('admin_roles'))
                            <tr>
                                <td>Group</td>
                                <td><a data-toggle="tooltip" title="Edit group: {{ $user->group->role->name }}" href="{{ route('backend.roles.edit', ['id' => $user->group->role_id]) }}">{{ $user->group->role->name }}</a></td>
                            </tr>
                        @endif
                    </table>
                </div>
            </div>
            <div class="row user-social-detail">
                <div class="col-lg-12 col-sm-12 col-12">
                    @if($user->connect->firstWhere('service', 'facebook'))
                        <a href="https://facebook.com/profile.php?id={{ $user->connect->firstWhere('service', 'facebook')->provider_id }}" target="_blank"><i class="fab fa-facebook-square"></i></a>
                    @endif
                    @if($user->connect->firstWhere('service', 'twitter'))
                        <a href="https://facebook.com/profile.php?id={{ $user->connect->firstWhere('service', 'twitter')->provider_id }}"><i class="fab fa-twitter-square"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
