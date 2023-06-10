@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('admin.pages') }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 py-3 border-left-info">
                <div class="card-body">
                    {{ __('admin.create_edit_pages') }}
                </div>
            </div>
            <a href="{{ route('backend.pages.add') }}" class="btn btn-primary">{{ __('admin.add_new_page') }}</a>
            <table class="mt-4 table table-striped">
                <thead>
                <tr>
                    <th>{{ __('admin.form_title') }}</th>
                    <th class="desktop">{{ __('admin.url') }}</th>
                    <th class="desktop">{{ __('admin.created_at') }}</th>
                    <th class="desktop">{{ __('admin.updated_at') }}</th>
                    <th class="th-3action">{{ __('admin.action') }}</th>
                </tr>
                </thead>
                @foreach ($pages as $index => $page)
                    <tr>
                        <td><a href="{{ route('backend.pages.edit', ['id' => $page->id]) }}">{{ $page->title }}</a></td>
                        <td class="desktop">{{ $page->alt_name }}</td>
                        <td class="desktop">{{ timeElapsedString($page->created_at) }}</td>
                        <td class="desktop">{{ timeElapsedString($page->updated_at) }}</td>
                        <td>
                            <a href="{{ route('backend.pages.edit', ['id' => $page->id]) }}" class="row-button edit"><i class="fas fa-fw fa-edit"></i></a>
                            <a href="{{ route('backend.pages.delete', ['id' => $page->id]) }}" class="row-button delete" onclick="return confirm('{{ __('admin.confirm_delete') }}')"><i class="fas fa-fw fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </table>

        </div>
    </div>
@endsection
