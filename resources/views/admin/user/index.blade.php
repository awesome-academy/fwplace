@extends('admin.layout.master')

@section('title', __('Employee'))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/sweet-alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/datatable.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Employee List') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Employee') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Employee List') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <h3 class="m-portlet__head-text">
                                {{ __('Employee List') }}
                            </h3>
                        </div>
                    </div>

                    <div class="m-portlet__head-tools">
                        <ul class="m-portlet__nav">

                            @if (Entrust::can(['add-users']))
                                <li class="m-portlet__nav-item">
                                    <a href="{{ url('admin/users/create') }}" class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air">
                                        <span>
                                            <i class="la la-plus"></i>
                                            <span>{{ __('New User') }}</span>
                                        </span>
                                    </a>
                                </li>
                            @endif
                            
                        </ul>
                    </div>
                </div>

                <div class="m-portlet__body">
                    {!! Form::open(['url' => 'admin/users', 'method' => 'GET', 'class' => 'm-form m-form--fit m--margin-bottom-20']) !!}
                        <div class="row m--margin-bottom-20">
                            <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                                {!! Form::label(__('Employee Name')) !!}
                                {!! Form::text('name', request('name'), ['class' => 'form-control m-input', 'placeholder' => __('Employee Name'), 'data-col-index' => 0]) !!}
                            </div>
                            <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                                {!! Form::label(__('Program')) !!}
                                {!! Form::select('program_id', $programs, request('program_id'), ['class' => 'form-control m-input', 'data-col-index' => 2]) !!}
                            </div>
                            <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                                {!! Form::label(__('Workspace')) !!}
                                {!! Form::select('workspace_id', $workspaces, request('workspace_id'), ['class' => 'form-control m-input', 'data-col-index' => 2]) !!}
                            </div>
                        </div>
                        <div class="row m--margin-bottom-20">
                            <div class="col-lg-3 m--margin-bottom-10-tablet-and-mobile">
                                {!! Form::label(__('Position')) !!}
                                {!! Form::select('position_id', $positions, request('position_id'), ['class' => 'form-control m-input', 'data-col-index' => 7]) !!}
                            </div>
                        </div>
                        <div class="m-separator m-separator--md m-separator--dashed"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                {!! Form::button('<i class="la la-search"><span></span></i>', ['type' => 'submit', 'class' => 'btn btn-brand m-btn m-btn--icon', 'id' => 'm_search']) !!}
                                {!! Form::button('<i class="la la-close"></i>', ['type' => 'reset', 'class' => 'btn btn-secondary m-btn m-btn--icon', 'id' => 'm_reset']) !!}
                            </div>
                        </div>
                    {!! Form::close() !!}

                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table m-table m-table--head-bg-primary">
                                <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Email') }}</th>
                                        <th>{{ __('Program') }}</th>
                                        <th>{{ __('Position') }}</th>
                                        <th>{{ __('Workspace') }}</th>
                                        <th>{{ __('Type') }}</th>
                                        <th>{{ __('Role') }}</th>
                                        <th>{{ __('Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(isset($users))
                                        @foreach($users as $key => $user)
                                            @if (Auth::user()->role == config('site.permission.admin') || $user->role != config('site.permission.admin'))
                                            <tr role="row" class="odd">
                                                <td class="sorting_1" tabindex="0">
                                                    <div class="m-card-user m-card-user--sm">
                                                        <div class="m-card-user__pic">
                                                            <div class="m-card-user__no-photo m--bg-fill-danger">
                                                                <span>
                                                                    {!! Html::image($user->avatarUser) !!}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="m-card-user__details">
                                                            <span class="m-card-user__name"><a href="{{ url('admin/schedule/users/' . $user->id) }}">{{ $user->name }}</a></span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>

                                                @if (!empty($user->program->name))
                                                    <td>{{ $user->program->name }}</td>
                                                @else
                                                    <td>{{ __('Not program') }}</td>
                                                @endif
                                                
                                                <td>{{ $user->position->name }}</td>

                                                @if (!empty($user->workspace->name))
                                                    <td>{{ $user->workspace->name }}</td>
                                                @else
                                                    <td>{{ __('Not workspace') }}</td>
                                                @endif

                                                @if ($user->position->is_fulltime == config('site.partime'))
                                                    <td>{{ __('Partime') }}</td>
                                                @else
                                                    <td>{{ __('Fulltime') }}</td>
                                                @endif
                                                
                                                <td>
                                                    @if (!empty($user->roles))
                                                        @foreach ($user->roles as $role)
                                                            @if ($role->display_name == 'Super Admin')
                                                                <span class="m-badge m-badge--danger m-badge--wide">
                                                                    {{ $role->display_name }}
                                                                </span>
                                                            @elseif ($role->display_name == 'Admin')
                                                                <span class="m-badge m-badge--success m-badge--wide">
                                                                    {{ $role->display_name }}
                                                                </span>
                                                            @elseif ($role->display_name == 'Trainer')
                                                                <span class="m-badge m-badge--primary m-badge--wide">
                                                                    {{ $role->display_name }}
                                                                </span>
                                                            @else
                                                                <span class="m-badge m-badge--info m-badge--wide">
                                                                    {{ $role->display_name }}
                                                                </span>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </td>

                                                <td>
                                                    @if (Entrust::can(['role-users']))
                                                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-success m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" data-toggle="m-tooltip" data-placement="top" data-original-title="{{ __('Role') }}">
                                                            <i class="flaticon-lock-1"></i>
                                                        </a>
                                                    @endif

                                                    @if (Entrust::can(['edit-users']))
                                                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" data-toggle="m-tooltip" data-placement="top" data-original-title="{{ __('Edit') }}">
                                                            <i class="flaticon-edit-1"></i>
                                                        </a>
                                                    @endif

                                                    @if (Entrust::can(['delete-users']))
                                                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                                        {!! Form::button('<i class="flaticon-cancel"></i>', ['type' => 'submit', 'class' => 'btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill delete', 'data-toggle' => 'm-tooltip', 'data-placement' => 'top', 'data-original-title' => __('Delete')]) !!}
                                                        {!! Form::close() !!}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        {{ $users->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>
@endsection
