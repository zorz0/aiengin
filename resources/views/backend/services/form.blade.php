@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ route('backend.services') }}"></a></li>
        <li class="breadcrumb-item active">@if(isset($service)) {{ $service->title }} @else {{ __('admin.add_new_plan') }} @endif</li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Title</label>
                    <div class="col-sm-6">
                        <input class="form-control" name="title" value="{{ isset($service) && ! old('title') ? $service->title : old('title') }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Give tokens</label>
                    <div class="col-sm-5">
                        <input class="form-control" name="tokens" value="{{ isset($service) && ! old('tokens') ? $service->tokens : old('tokens') }}" type="number" required>
                    </div>
                    <div class="col-sm-5 d-none">
                        <div class="input-group col-xs-12">
                            <span class="input-group-addon"><i class="fas fa-fw fa-money-check"></i></span>
                            <input type="text" class="form-control input-lg number" name="plan_period" value="1" placeholder="0">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">{{ __('admin.plan_period') }}</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Description</label>
                    <div class="col-sm-6">
                        <textarea class="form-control editor" rows="10" name="description" required>{{ isset($service) && ! old('description') ? $service->description : old('description') }}</textarea>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">Price</label>
                    <div class="col-sm-5">
                        <div class="input-group col-xs-12">
                            <span class="input-group-addon"><i class="fas fa-fw fa-money-check"></i></span>
                            <input type="text" class="form-control input-lg money" name="price" value="{{ isset($service) && ! old('price') ? $service->price : old('price') }}" placeholder="0.00" required>
                            <span class="input-group-btn"><button class="browse btn btn-primary input-lg" type="button"><i class="fas fa-fw fa-hand-holding-usd"></i> {{ __('currency.'. config('settings.currency', 'USD')) }}</button></span>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">In {{ __('currency.'. config('settings.currency', 'USD')) }}, numeric only</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">@lang('admin.plan_period')</label>
                    <div class="col-sm-5">
                        {!! makeDropDown( array("M" => __("alerts.monthly"), "Y" => __("alerts.yearly")), "plan_period_format", isset($service) ? $service->plan_period_format : old('plan_period_format') ) !!}
                        <small id="emailHelp" class="form-text text-muted">@lang('admin.plan_period_type')</small>
                    </div>
                    <div class="col-sm-5 d-none">
                        <div class="input-group col-xs-12">
                            <span class="input-group-addon"><i class="fas fa-fw fa-money-check"></i></span>
                            <input type="text" class="form-control input-lg number" name="plan_period" value="1" placeholder="0">
                        </div>
                        <small id="emailHelp" class="form-text text-muted">@lang('admin.plan_period_desc')</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">@lang('admin.add_user_to_group')</label>
                    <div class="col-sm-5">
                        {!! makeRolesDropDown('role_id', isset($service) && ! old('role_id') ? $service->role_id : old('role_id'), 'required') !!}
                        <small id="emailHelp" class="form-text text-muted">@lang('admin.set_permission')</small>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-6 col-form-label">@lang('admin.is_active')</label>
                    <div class="col-sm-6">
                        <label class="switch">
                            {!! makeCheckBox('active', isset($service) && ! old('active') ? $service->active : (old('active') ? old('active') : 1)) !!}
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">@lang('admin.save')</button>
                <button type="reset" class="btn btn-info">@lang('admin.reset')</button>
            </form>
        </div>
    </div>
@endsection
