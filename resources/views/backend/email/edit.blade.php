@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('backend.email') }}">{{ __('admin.email_template')}}</a></li>
        <li class="breadcrumb-item active">{{ $email->description }}</li>

    </ol>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">{{ $email->description }}</h6>
        </div>
        <div class="card-body">
            <form role="form" method="post" action="" enctype="multipart/form-data">
                @csrf

                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.subject') }}
                        <p class="small">{{ __('admin.subject_description') }}</p>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control" name="subject" value="{{ $email->subject }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.email_body') }}
                        <p class="small">{{ __('admin.email_body_description') }}</p>
                    </label>
                    <div class="col-sm-8">
                        <textarea class="form-control default editor" rows="6" name="content">{{ $email->content }}</textarea>
                    </div>
                </div>
                <input type="hidden" name="action" value="add">
                <button type="submit" class="btn btn-primary">Save</button>
                <button type="reset" class="btn btn-info">Reset</button>
            </form>
        </div>
    </div>
@endsection
