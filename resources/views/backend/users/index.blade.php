@extends('backend.index')
@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('backend.dashboard') }}">{{ __('admin.control_panel') }}</a>
        </li>
        <li class="breadcrumb-item active">{{ __('admin.users_total', ['total_users' => $total_users]) }}</li>
        <li class="breadcrumb-item active">{{ __('admin.manage_registered_users') }}</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 border-0">
                    <button class="btn btn-link p-0 m-0" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h6 class="m-0 font-weight-bold text-primary">@lang('admin.advanced_user_search')</h6>
                    </button>
                    <a href="{{ route('backend.users.add') }}" class="btn btn-primary btn-sm float-right">@lang('admin.add_new_user')</a>
                </div>
                <div class="card-body p-0">
                    <div class="accordion" id="collapseMetaTags">
                        <div id="collapseOne" class="collapse p-4" aria-labelledby="headingOne" data-parent="#collapseMetaTags">
                            <form class="search-form" action="{{ route('backend.users') }}">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <div class="input-group mr-3">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">{{ __('alerts.email') }}</div>
                                            </div>
                                            <input type="text" class="form-control" name="email" value="{{ request()->input('email') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <p class="mb-2">{{ __('alerts.registration_date') }}</p>
                                        <div class="form-inline">
                                            <div class="input-group mr-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('alerts.from') }}</div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-with-form" name="created_from" value="{{ request()->input('created_from') }}" autocomplete="off">
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('alerts.until') }}</div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-with-form" name="created_until" value="{{ request()->input('created_until') }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <p class="mb-2">{{ __('alerts.last_visit_date') }}</p>
                                        <div class="form-inline">
                                            <div class="input-group mr-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('alerts.from') }}</div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-with-form" name="logged_from" value="{{ request()->input('logged_from') }}" autocomplete="off">
                                            </div>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('alerts.until') }}</div>
                                                </div>
                                                <input type="text" class="form-control datetimepicker-with-form" name="logged_until" value="{{ request()->input('logged_until') }}" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>



                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <p class="mb-2">{{ __('alerts.number_of_comments') }}:</p>
                                        <div class="form-inline">
                                            <div class="input-group mb-2 mr-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('alerts.from') }}</div>
                                                </div>
                                                <input type="text" class="form-control" name="comment_count_from" value="{{ request()->input('comment_count_from') }}">
                                            </div>
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('alerts.until') }}</div>
                                                </div>
                                                <input type="text" class="form-control" name="comment_count_until" value="{{ request()->input('comment_count_until') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <p class="mb-2">{{ __('alerts.group') }}:</p>
                                        <div class="form-inline">
                                            {!! makeRolesDropDown('group', request()->input('group')) !!}
                                            <div class="input-group ml-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">{{ __('alerts.results_per_page') }}</div>
                                                </div>
                                                <input type="text" class="form-control" name="results_per_page" value="{{ request()->input('results_per_page') ? request()->input('results_per_page') : 50 }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="exact_username" @if(request()->input('exact_username')) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox1">{{ __('alerts.exact_match_of_username') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="1" name="banned" @if(request()->input('banned')) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox2">{{ __('alerts.banned') }}</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="1" name="comment_disabled" @if(request()->input('comment_disabled')) checked @endif>
                                        <label class="form-check-label" for="inlineCheckbox3">{{ __('alerts.disable_comments') }}</label>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ __('alerts.find') }}</button>
                                <button type="reset" class="btn btn-danger">{{ __('alerts.reset') }}</button>
                                <a href="{{ route('backend.users') }}" class="btn btn-secondary">{{ __('alerts.clear') }}</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <form id="mass-action-form" method="post" action="{{ route('backend.users.mass.action') }}">
                @csrf
                <table class="table table-striped datatables table-hover">
                    <colgroup>
                        <col class="span1">
                        <col class="span7">
                    </colgroup>
                    <thead>
                    <tr>
                        <th class="th-image"></th>
                        <th>Name</th>
                        <th class="desktop">Email</th>
                        <th class="desktop">Group</th>
                        <th class="desktop">Joined</th>
                        <th class="desktop">Last visited</th>
                        <th class="desktop text-center th-2action" data-toggle="tooltip" title="Number of news articles"><i class="fas fa-newspaper"></i></th>
                        <th class="th-2action desktop">Action</th>
                        <th class="th-checkbox">
                            <label class="engine-checkbox">
                                <input id="check-all" class="multi-check-box" type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @include('backend.commons.user', ['users' => $users])
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-6">{{ $users->appends(request()->input())->links('pagination::bootstrap-4', ['class' => 'pagination-nav']) }}</div>
                    <div class="col-6">
                        <div class="form-inline float-sm-right">
                            <div class="form-group mb-2">
                                <select name="action" class="form-control mr-2">
                                    <option value="">-- Action --</option>
                                    @if(\App\Models\Role::getValue('admin_roles'))
                                        <option value="change_usergroup">Change group</option>
                                    @endif
                                    <option value="ban_user">Ban users</option>
                                    <option value="delete_comment">Delete comments</option>
                                    <option value="delete">Delete users</option>
                                </select>
                            </div>
                            <button id="start-mass-action" type="button" class="btn btn-primary mb-2">Start</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
