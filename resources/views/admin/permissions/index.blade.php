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
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Permission') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <table class="table table-striped- table-bordered table-hover table-checkable" id="permissions_table">
                <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th>{{ __('Display name') }}</th>
                        <th>{{ __('Permission') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Created at') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {!! Form::hidden('processing_lang', __('Processing'), ['id' => 'processing_lang']) !!}

@endsection

@section('js')
    <script src="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('bower_components/metro-asset/demo/default/custom/crud/datatables/data-sources/html.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/toastr.min.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>

    @routes
    <script src="{{ mix('js/permission.js') }}"></script>
@endsection
