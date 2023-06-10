@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('admin.create_and_manage_news_category') }}</li>
    </ol>


    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">{{ __('admin.categories') }}</h6>
            <h6 class="m-0 font-weight-bold float-right"><a class="text-primary" href="{{ route('backend.categories.add') }}">{{ __('admin.add_new_category') }}</a></h6>
        </div>
        <div class="card-body">
            <form role="form" method="post" action="" enctype="multipart/form-data">
                @csrf
                <div class="dd nestable-with-handle">
                    <ol class="dd-list">
                        {!! $nestable_categories !!}
                    </ol>
                </div>
                <input type="hidden" name="list" id="cartSortList">
                <button type="submit" class="btn btn-primary mt-4">{{ __('admin.save_sort_order') }}</button>
            </form>
        </div>
    </div>
@endsection
