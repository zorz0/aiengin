@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('admin.create_update_maps') }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-7 col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <li class="breadcrumb-item active">{{ __('admin.create_update_maps') }}</li>
                </div>
                <div class="card-body">
                    @if(isset($filemtime))
                        <div class="card mt-4 py-3 border-left-info">
                            <div class="card-body card-small">
                                <p class="mb-0">{{ __('admin.index_file_created') }} <strong class="text-success">{{ $filemtime }}</strong> ({{ __('admin.server_time') }}) {{ __('admin.available_at') }} <a href="{{ route('frontend.homepage') }}/sitemap.xml" target="_blank">{{ route('frontend.homepage') }}/sitemap.xml</a></p>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-12">
                            <form method="post" action="{{ route('backend.sitemap.make') }}">
                                @csrf
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.post_articles') }}
                                        <p class="small mb-0">{{ __('admin.post_articles_desc') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="post_num" value="100" required="">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.music_item') }}
                                        <p class="small mb-0">{{ __('admin.music_item_desc') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="song_num" value="100" required="">
                                    </div>
                                </div>
                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.static_priority') }}
                                        <p class="small mb-0">{{ __('admin.static_priority_desc') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="static_priority" value="0.5" required="">
                                    </div>
                                </div>



                                <div class="form-group row border-bottom mb-0 pt-3 pb-3">
                                    <label class="col-sm-8 mb-0">{{ __('admin.blog_priority_label') }}
                                        <p class="small mb-0">{{ __('admin.blog_priority_description') }}</p>
                                    </label>
                                    <div class="col-sm-4">
                                        <input class="form-control" name="blog_priority" value="0.5" required="">
                                    </div>
                                </div>
                                <button type="btn btn-primary" class="btn btn-primary mt-4">{{ __('admin.create_button') }}</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">@lang('admin.sitemap_step_1')</h6>
                </div>
                <div class="card-body">
                    <div class="card mt-4 py-3 border-left-info">
                        <div class="card-body card-small">
                            <p>@lang('admin.sitemap_step_2')</p>
                            <p>@lang('admin.sitemap_step_3')</p>
                            <p>@lang('admin.sitemap_step_4')</p>
                            <p class="mb-0">@lang('admin.sitemap_step_5')</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
