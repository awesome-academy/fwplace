@extends('admin.layout.master')

@section('title', __('Role'))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/sweet-alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/datatable.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Role') }}</h3>

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
                <span class="m-nav__link-text">{{ __('Role') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__head">
            <div class="m-portlet__head-tools">
                <ul class="m-portlet__nav">
                    <li class="m-portlet__nav-item">
                        <a class="btn btn-primary m-btn m-btn--pill m-btn--custom m-btn--icon m-btn--air" id="add_role_a">
                            <span>
                                <i class="la la-plus"></i>
                                <span>{{ __('New Role') }}</span>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="m-portlet__body">
            <table class="table table-striped- table-bordered table-hover table-checkable" id="roles_table">
                <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th>{{ __('Display name') }}</th>
                        <th>{{ __('Role') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="add_role_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add new role') }}</h5>
                    {!! Form::button('<span aria-hidden="true">&times;</span>', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) !!}
                </div>

                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'id' => 'add_role_form', 'name' => 'add_role_form']) !!}

                        <div class="form-group">
                            {!! Form::label(__('Display name'), null, ['for' => 'recipient-name', 'class' => 'form-control-label']) !!}
                            {!! Form::text('display_name', null, ['class' => 'form-control', 'id' => 'display_name']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label(__('Role'), null, ['for' => 'recipient-name', 'class' => 'form-control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label(__('Description'), null, ['for' => 'message-text', 'class' => 'form-control-label']) !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description', 'rows' => 2]) !!}
                        </div>

                    {!! Form::close() !!}
                </div>

                <div class="modal-footer">
                    {!! Form::button(__('Close'), ['type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button(__('Create'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'add_role_btn']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_role_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit role') }}</h5>
                    {!! Form::button('<span aria-hidden="true">&times;</span>', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) !!}
                </div>

                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'id' => 'edit_role_form', 'name' => 'edit_role_form']) !!}
                        {!! Form::hidden('_method', 'PUT') !!}
                        {!! Form::hidden('role_id', null, ['id' => 'role_id']) !!}

                        <div class="form-group">
                            {!! Form::label(__('Display name'), null, ['for' => 'recipient-name', 'class' => 'form-control-label']) !!}
                            {!! Form::text('display_name', null, ['class' => 'form-control', 'id' => 'edit_display_name']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label(__('Role'), null, ['for' => 'recipient-name', 'class' => 'form-control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'edit_name']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label(__('Description'), null, ['for' => 'message-text', 'class' => 'form-control-label']) !!}
                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'edit_description', 'rows' => 2]) !!}
                        </div>

                    {!! Form::close() !!}
                </div>

                <div class="modal-footer">
                    {!! Form::button(__('Close'), ['type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'edit_role_btn']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::hidden('processing_lang', __('Processing'), ['id' => 'processing_lang']) !!}
    {!! Form::hidden('required_lang', __('Required'), ['id' => 'required_lang']) !!}
    {!! Form::hidden('display_name_lang', __('Display name'), ['id' => 'display_name_lang']) !!}
    {!! Form::hidden('role_lang', __('Role'), ['id' => 'role_lang']) !!}
    {!! Form::hidden('add_success_lang', __('Add success'), ['id' => 'add_success_lang']) !!}
    {!! Form::hidden('edit_success_lang', __('Edit success'), ['id' => 'edit_success_lang']) !!}
    {!! Form::hidden('question_delete_lang', __('Question delete'), ['id' => 'question_delete_lang']) !!}
    {!! Form::hidden('delete_success_lang', __('Delete success'), ['id' => 'delete_success_lang']) !!}
    {!! Form::hidden('yes_lang', __('Yes'), ['id' => 'yes_lang']) !!}
    {!! Form::hidden('no_lang', __('No'), ['id' => 'no_lang']) !!}
    {!! Form::hidden('permission_lang', __('Permission'), ['id' => 'permission_lang']) !!}
    {!! Form::hidden('edit_lang', __('Edit'), ['id' => 'edit_lang']) !!}
    {!! Form::hidden('delete_lang', __('Delete'), ['id' => 'delete_lang']) !!}

@endsection

@section('js')
    <script src="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('bower_components/metro-asset/demo/default/custom/crud/datatables/data-sources/html.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/toastr.min.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>

    @routes
    <script src="{{ mix('js/role.js') }}"></script>
@endsection
