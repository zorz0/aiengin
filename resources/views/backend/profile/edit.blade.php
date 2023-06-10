@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('admin.profile') }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.edit_profile') }}</h6>
                </div>
                <div class="card-body">
                    <form role="form" action="" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.avatar') }}</label>
                            <div class="col-sm-8">
                                <div class="input-group col-xs-12">
                                    <input type="file" name="artwork" class="file-selector" accept="image/*">
                                    <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                                    <input type="text" class="form-control input-lg" disabled placeholder="{{ __('admin.upload_image') }}">
                                    <span class="input-group-btn"><button class="browse btn btn-primary input-lg" type="button"><i class="fas fa-fw fa-file"></i> {{ __('admin.browse') }}</button></span>
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
                            <label class="col-sm-4 col-form-label">{{ __('admin.block_email') }}</label>
                            <div class="col-sm-8 col-3">
                                <label class="switch"><input type="checkbox" name="blockEmail"><span class="slider round"></span></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.password') }}</label>
                            <div class="col-sm-8">
                                <input class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.remove_avatar') }}</label>
                            <div class="col-sm-8 col-3">
                                <label class="switch"><input type="checkbox" name="removeArtwork"><span class="slider round"></span></label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.delete_comments') }}</label>
                            <div class="col-sm-8">
                                <label class="switch">
                                    <input type="checkbox" name="deleteComments">
                                    <span class="slider round"></span>
                                </label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">{{ __('admin.about_me') }}</label>
                            <div class="col-sm-8">
                                <textarea class="form-control editor" rows="2" name="about"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="doEdit" value="true">
                        <button type="submit" class="btn btn-primary">{{ __('admin.send') }}</button>
                        <button type="reset" class="btn btn-info">{{ __('admin.reset') }}</button>
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
                    <img src="{{ $user->artwork_url ?  $user->artwork_url : url('common/default/user.svg') }}" class="rounded-circle img-thumbnail">
                    <h5>{{ $user->name }}</h5>
                    <p>{{ $user->email }}</p>
                    <table class="mt-4 table table-striped">
                        <tr>
                            <td>E-Mail</td>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Registered</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        <tr>
                            <td>Recent Activity</td>
                            <td>{{ $user->last_activity }}</td>
                        </tr>
                        <tr>
                            <td>IP</td>
                            <td>{{ $user->logged_ip }}</td>
                        </tr>
                        <tr>
                            <td>Group</td>
                            <td>{{ \App\Models\Role::getValue('group_name') }}</td>
                        </tr>
                        <tr>
                            <td>Badge</td>
                            <td>{!! \App\Models\Role::getValue('group_badge') !!}</td>
                        </tr>
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
