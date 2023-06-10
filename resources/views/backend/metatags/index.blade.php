@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item"><a href="{{ route('backend.metatags') }}">{{ __('admin.manage_meta_tags') }}</a></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 border-0">
                    <button class="btn btn-link p-0 m-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.add_new_page_title') }}</h6>
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="collapseMetaTags">
                        <div id="collapseOne" class="collapse p-4" aria-labelledby="headingOne" data-parent="#collapseMetaTags">
                            <form role="form" method="post" action="" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label class="col-sm-4">{{ __('admin.url_label') }}
                                        <p class="small">{{ __('admin.url_info') }}</p>
                                    </label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="url" required>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">{{ __('admin.info_label') }}</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="info">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">{{ __('admin.title_label') }}</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" name="title" required placeholder="{{ __('admin.title_required') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">{{ __('admin.description_label') }}
                                        <p class="small">{{ __('admin.description_info') }}</p>
                                    </label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" rows="2" name="description"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">{{ __('admin.keywords_label') }}</label>
                                    <div class="col-sm-8">
                                        {!! makeTagSelector('keywords[]', isset($metatag) && ! old('keywords') ? $metatag->meta_keywords : old('keywords')) !!}
                                    </div>
                                </div>
                                <div class="form-group row border-bottom">
                                    <label class="col-sm-4">{{ __('admin.auto_general_keywords_label') }}
                                        <p class="small">{{ __('admin.auto_general_keywords_description') }}</p>
                                    </label>
                                    <div class="col-sm-8 col-9">
                                        <label class="switch">
                                            {!! makeCheckBox('auto_keyword', 0) !!}
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-4">{{ __('admin.page_artwork_label') }}
                                        <p class="small mt-2">{{ __('admin.page_artwork_info') }}</p>
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="input-group col-xs-12">
                                            <input type="file" name="artwork" class="file-selector" accept="image/*">
                                            <span class="input-group-addon"><i class="fas fa-fw fa-image"></i></span>
                                            <input type="text" class="form-control input-lg" disabled placeholder="Upload Image">
                                            <span class="input-group-btn">
                                                <button class="browse btn btn-primary input-lg" type="button">><i class="fas fa-fw fa-file"></i> {{ __('admin.browse_btn') }}</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="action" value="add">
                                <button type="submit" class="btn btn-primary">Create</button>
                                <button type="reset" class="btn btn-info">Reset</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ __('admin.manage_titles') }}</h6>
                </div>
                <div class="card-body">
                    <form method="post" action="{{ route('backend.metatags.sort.post') }}">
                        @csrf
                        <table class="table table-striped table-sortable">
                            <thead>
                            <tr>
                                <th class="th-handle"></th>
                                <th class="{{ __('admin.priority') }}">Priority</th>
                                <th class="{{ __('admin.image') }}">Image</th>
                                <th>{{ __('admin.alternative_name') }}</th>
                                <th>{{ __('admin.url') }}</th>
                                <th>{{ __('admin.description') }}</th>
                                <th class="{{ __('admin.action') }}">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($metatags as $index => $metatag)
                                <tr data-id="{{ $metatag->id }}">
                                    <td><i class="handle fas fa-fw fa-arrows-alt"></i></td>
                                    <td><input type="hidden" name="metaIds[]" value="{{ $metatag->id }}"></td>
                                    <td><img src="{{ $metatag->artwork_url }}"/></td>

                                    <td>{{ $metatag->url }}</td>
                                    <td><span title="{{ url($metatag->url) }}">{{ url($metatag->url) }}</span></td>
                                    <td>{{ $metatag->info }}</td>
                                    <td>
                                        <a href="{{ route('backend.metatags.edit', ['id' => $metatag->id]) }}" class="row-button edit"><i class="fas fa-fw fa-edit"></i></a>
                                        <a href="{{ route('backend.metatags.delete', ['id' => $metatag->id]) }}" onclick="return confirm('Are you sure?')" class="row-button delete"><i class="fas fa-fw fa-trash"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                    <div class="card mt-4 py-3 border-left-info">
                        <div class="card-body card-small">
                            <p class="mb-0">{{ __('admin.meta_tags_assignment') }}</p>
                        </div>
                    </div>
                    <div class="card mt-4 py-3 border-left-info">
                        <div class="card-body card-small">
                            <p>{{ __('admin.meta_tags_info') }}</p>
                            <p>{!! __('admin.title_tag_info') !!}</p>
                            <p>{!! __('admin.description_tag_info') !!}</p>
                            <p class="mb-0">{!! __('admin.keywords_tag_info') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
