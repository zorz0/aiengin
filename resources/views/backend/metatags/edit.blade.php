@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ route('backend.metatags') }}">Metatags</a></li>
        <li class="breadcrumb-item active">For URL: {{ $metatag->url }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <form method="post" action="" class="form-horizontal" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.url_label') }}
                        <p class="small">{{ __('admin.url_info') }}</p>
                    </label>
                    <div class="col-sm-8">
                        <input class="form-control" name="url" value="{{ $metatag->url }}" required>
                        @error('url')
                        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.info_label') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" value="{{ $metatag->info }}" name="info">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.title_label') }}</label>
                    <div class="col-sm-8">
                        <input class="form-control" name="title" value="{{ $metatag->page_title }}" required>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.description_label') }}
                        <p class="small">{{ __('admin.description_info') }}</p>
                    </label>
                    <div class="col-sm-8">
                        <textarea class="form-control" rows="2" name="description">{{ $metatag->page_description }}</textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.keywords_label') }}</label>
                    <div class="col-sm-8">
                        {!! makeTagSelector('keywords[]', isset($metatag) && ! old('keywords') ? $metatag->page_keywords : old('keywords')) !!}
                    </div>
                </div>
                <div class="form-group row border-bottom">
                    <label class="col-sm-4">{{ __('admin.auto_general_keywords_label') }}
                        <p class="small">{{ __('admin.auto_general_keywords_description') }}</p>
                    </label>
                    <div class="col-sm-8 col-9">
                        <label class="switch">
                            {!! makeCheckBox('auto_keyword', $metatag->auto_keyword) !!}
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4">{{ __('admin.page_artwork_label') }}
                        <p class="small mt-2">{{ __('admin.page_artwork_description') }}</p>
                    </label>
                    <div class="col-sm-8">
                        <div class="input-group col-xs-12">
                            <input type="file" name="artwork" class="file-selector" accept="image/*">
                            <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                            <input type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                            <span class="input-group-btn"><button class="browse btn btn-primary input-lg" type="button">><i class="fas fa-fw fa-file"></i> {{ __('admin.browse_btn') }}</button></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection
