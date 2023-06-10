@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ url('admin/subscriptions') }}">{{ __('admin.subscription_breadcrumb') }}</a></li>
        <li class="breadcrumb-item active">{{ $order->user->name }}</li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <form role="form" action="" enctype="multipart/form-data" method="post">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-2">{{ __('admin.payment_method') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        {{ ucwords($order->payment) }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">{{ __('admin.plan') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        {{ ucwords($order->service->title) }}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.transaction_id') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        <input class="form-control" name="title" value="{{ isset($order) ? $order->transaction_id : old('transaction_id') }}" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.amount') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        <div class="input-group col-xs-12">
                            <span class="input-group-addon"><i class="fas fa-fw fa-money-check"></i></span>
                            <input type="text" class="form-control input-lg money" name="price" value="{{ isset($order) ? $order->amount : old('amount') }}" placeholder="0.00" required>
                            <span class="input-group-btn"><button class="browse btn btn-primary input-lg" type="button"><i class="fas fa-fw fa-hand-holding-usd"></i> USD</button></span>
                        </div>
                        <small id="emailHelp" class="form-text text-muted">{{ __('admin.amount_help') }}</small>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.status') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        {!! makeDropDown( array("0" => __("alerts.failed"), "1" => __("alerts.success")), "payment_status", isset($order) ? $order->payment_status : old('payment_status') ) !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputUser" class="col-sm-2 control-label">{{ __('admin.customer') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        <select class="form-control select-ajax" data-ajax--url="{{ route('api.search.user') }}" name="user_id">
                            <option value="{{ $order->user->id }}" selected="selected" data-artwork="{{ $order->user->artwork_url }}">{{ $order->user->name }}</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.move_user_to_group') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        {!! makeRolesDropDown('role', $order->user->group->role_id, 'required') !!}
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">{{ __('admin.end_at') }}</label>
                    <div class="col-lg-6 col-sm-9 col-12">
                        <input class="form-control datetimepicker-no-mask" name="end_at" value="{{ \Carbon\Carbon::now()->format('Y/m/d H:i') }}" autocomplete="off">
                        <small class="form-text text-muted">{{ __('admin.send_user_back_to_default_group') }}</small>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('admin.save') }}</button>
                <button type="reset" class="btn btn-info">{{ __('admin.reset') }}</button>
            </form>
        </div>
    </div>
@endsection
