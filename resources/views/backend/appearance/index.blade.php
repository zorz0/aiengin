@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ config('settings.admin_path') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('admin.appearance') }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 py-3 border-left-info">
                <div class="card-body">
                    Configure Appearance
                </div>
            </div>
            <form method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                            <label class="col-sm-8 mb-0">@lang('admin.color_scheme')
                                <p class="small mb-0">@lang('admin.color_scheme_description')</p>
                            </label>
                            <div class="col-sm-4">
                                {!! makeDropDown(array(0 => __('admin.light_mode'), 1 => __('admin.dark_mode')), "save_con[dark_mode]", config('settings.dark_mode', true) ) !!}
                            </div>
                        </div>
                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                            <label class="col-sm-8 mb-0">@lang('admin.favicon')
                                <p class="small mb-0">@lang('admin.favicon_description')</p>
                            </label>
                            <div class="col-sm-4">
                                <div class="input-group col-xs-12">
                                    <input type="file" name="favicon" class="file-selector" accept="image/*">
                                    <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                                    <input type="text" class="form-control input-lg" disabled placeholder="@lang('admin.upload_image')">
                                    <span class="input-group-btn">
                <button class="browse btn btn-primary input-lg" type="button"><i class="fas fa-fw fa-image"></i> @lang('admin.browse')</button>
            </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                            <label class="col-sm-8 mb-0">@lang('admin.logo')</label>
                            <div class="col-sm-4">
                                <div class="input-group col-xs-12">
                                    <input type="file" name="logo" class="file-selector" accept="image/*">
                                    <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                                    <input type="text" class="form-control input-lg" disabled placeholder="@lang('admin.upload_image')">
                                    <span class="input-group-btn">
                <button class="browse btn btn-primary input-lg" type="button"><i class="fas fa-fw fa-image"></i> @lang('admin.browse')</button>
            </span>
                                </div>
                            </div>
                        </div>
                        <p class="mt-4 font-weight-bold text-danger">@lang('admin.clear_browser_cache')</p>
                    </div>
                </div>
                <div class="mt-3 clearfix">
                    <button type="submit" class="btn btn-primary">{{ __('admin.save_btn') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
