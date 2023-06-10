@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active"><a href="{{ route('backend.categories') }}">Categories</a></li>
        <li class="breadcrumb-item active">{{ isset($category) ? $category->name : 'Add new category' }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <form role="form" method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">@lang('admin.name')
                        <p class="small">@lang('admin.name_help')</p>
                    </label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="name" value="{{ isset($category) ? $category->name : old('name') }}" required>
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">@lang('admin.alt_name')</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="alt_name" value="{{ isset($category) ? $category->alt_name : old('alt_name') }}">
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">@lang('admin.description')</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="2" name="description">{{ isset($category) ? $category->description : old('description') }}</textarea>
                    </div>
                </div>

                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">@lang('admin.meta_title')</label>
                    <div class="col-sm-9">
                        <input class="form-control" type="text" name="meta_title" value="{{ isset($category) ? $category->meta_title : old('meta_title') }}" placeholder="@lang('admin.meta_title_placeholder')">
                    </div>
                </div>

                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3 col-form-label">{{ __('admin.meta_description') }}</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" rows="2" name="meta_description" placeholder="{{ __('admin.meta_description') }}">{{ isset($category) ? $category->meta_description : old('meta_description') }}</textarea>
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3 col-form-label">{{ __('admin.meta_keywords') }}</label>
                    <div class="col-sm-9">
                        {!! makeTagSelector('meta_keywords[]',isset($category) ? $category->meta_keywords : old('meta_keywords')) !!}
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">{{ __('admin.news_sort') }}</label>
                    <div class="col-sm-9">
                        {!! makeDropDown( array("0" => trans('admin.news_sort'), "1" => trans('admin.news_sort'), "2" => trans('admin.news_sort'), "3" => trans('admin.news_sort'), "4" => trans('admin.news_sort')), "news_sort", isset($category) ? $category->meta_description : old('news_sort') ) !!}
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">{{ __('admin.show_sub') }}</label>
                    <div class="col-sm-9">
                        {!! makeDropDown( array("0" => trans('admin.show_sub'), "1" => trans('admin.show_sub'), "2" => trans('admin.show_sub')), "show_sub", isset($category) ? $category->meta_description : old('show_sub') ) !!}
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">{{ __('admin.disable_main') }}</label>
                    <div class="col-sm-9">
                        <label class="switch">
                            {!! makeCheckBox('disable_main', isset($category) ? $category->disable_main : old('disable_main')) !!}
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">{{ __('admin.disable_comments_label') }}</label>
                    <div class="col-sm-9">
                        <label class="switch">
                            {!! makeCheckBox('disable_comments', isset($category) ? $category->disable_comments : old('disable_comments')) !!}
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                    <label class="col-sm-3">{{ __('admin.exclude_from_search_label') }}</label>
                    <div class="col-sm-9">
                        <label class="switch">
                            {!! makeCheckBox('disable_search', isset($category) ? $category->disable_search : old('disable_search')) !!}
                            <span class="slider round"></span>
                        </label>
                    </div>
                </div>
                <div class="form-group row border-bottom mb-4 pt-3 pb-3">
                    <label class="col-sm-3">{{ __('admin.artwork_label') }}</p></label>
                    <div class="col-sm-9">
                        <div class="input-group col-xs-12">
                            <input type="file" name="artwork" class="file-selector" accept="image/*">
                            <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                            <input type="text" class="form-control input-lg" disabled placeholder="{{ __('admin.upload_image_placeholder') }}">
                            <span class="input-group-btn"><button class="browse btn btn-primary input-lg" type="button">><i class="fas fa-fw fa-file"></i> {{ __('admin.browse_btn') }}</button></span>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">{{ __('admin.create_btn') }}</button>
                <button type="reset" class="btn btn-info">{{ __('admin.reset_btn') }}</button>
            </form>
        </div>
    </div>
@endsection
