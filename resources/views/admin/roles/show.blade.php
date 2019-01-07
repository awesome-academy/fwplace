@extends('admin.layout.master')

@section('title', __('Permission'))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/sweet-alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/datatable.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Permission') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('System Management') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a href="{{ route('roles.index') }}" class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Role') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Permission') }}</span>
            </a>
        </li>
    </ul>
@endsection

@section('content')

	<div class="m-portlet m-portlet--mobile">
        {!! Form::hidden('role_id', $role_id, ['id' => 'role_id']) !!}

        <div class="m-portlet__body">
            <table class="table table-striped- table-hover table-checkable" id="permission_role_table">
                <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th>{{ __('Permission') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    {!! Form::hidden('processing_lang', __('Processing'), ['id' => 'processing_lang']) !!}
    {!! Form::hidden('add_success_lang', __('Add success'), ['id' => 'add_success_lang']) !!}
    {!! Form::hidden('delete_success_lang', __('Delete success'), ['id' => 'delete_success_lang']) !!}
    {!! Form::hidden('add_lang', __('Add'), ['id' => 'add_lang']) !!}
    {!! Form::hidden('delete_lang', __('Delete'), ['id' => 'delete_lang']) !!}

@endsection

@section('js')
    <script src="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('bower_components/metro-asset/demo/default/custom/crud/datatables/data-sources/html.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/toastr.min.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>

    @routes
    <script src="{{ mix('js/permission-role.js') }}"></script>
@endsection
