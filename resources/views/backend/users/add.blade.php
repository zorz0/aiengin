@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ route('backend.users') }}">Users</a></li>
        <li class="breadcrumb-item active">Add new user</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.name_label') }}</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="name" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.artwork_label') }}</label>
                    <div class="col-sm-10">
                        <div class="input-group col-xs-12">
                            <input type="file" name="artwork" class="file-selector" accept="image/*">
                            <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                            <input type="text" class="form-control input-lg" disabled placeholder="{{ __('admin.upload_image_placeholder') }}">
                            <span class="input-group-btn"><button class="browse btn btn-primary input-lg" type="button"><i class="fas fa-fw fa-file"></i> {{ __('admin.browse_btn') }}</button></span>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">{{ __('admin.image_size_note') }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.email_label') }}</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="email">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.do_not_receive_emails_label') }}</label>
                    <div class="col-sm-10 col-3">
                        <label class="switch"><input type="checkbox" name="blockEmail]"><span class="slider round"></span></label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.password_label') }}</label>
                    <div class="col-sm-10">
                        <input class="form-control" name="password" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.banned_label') }}</label>
                    <div class="col-sm-10 col-3">
                        <label class="switch"><input type="checkbox" name="bannedUser]"><span class="slider round"></span></label>
                    </div>
                </div>
                @if(\App\Models\Role::getValue('admin_roles'))
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">{{ __('admin.group_label') }}</label>
                        <div class="col-sm-10">
                            {!! makeRolesDropDown('role', null, 'required') !!}
                        </div>
                    </div>
                @endif

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Remove avatar?</label>
                    <div class="col-sm-10 col-3">
                        <label class="switch">
                            <input type="checkbox" name="removeArtwork]">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.delete_comments_label') }}</label>
                    <div class="col-sm-10 col-3">
                        <label class="switch">
                            <input type="checkbox" name="deleteComments]">
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.block_by_ip_label') }}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control editor" rows="2" name="blockIps"></textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.about_label') }}</label>
                    <div class="col-sm-10">
                        <textarea class="form-control editor" rows="2" name="about"></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('admin.send_btn') }}</button>
                <button type="reset" class="btn btn-info">{{ __('admin.reset_btn') }}</button>
            </form>
        </div>
    </div>
@endsection
