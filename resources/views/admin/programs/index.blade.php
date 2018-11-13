@extends('admin.layout.master')

@section('title', __('Programs') )

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/sweet-alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/datatable.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Programs') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Programs') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table table-striped- table-bordered m-table m-table--head-bg-success" id="programs_table">
                                <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Name Program') }}</th>

                                        @if (Entrust::can(['add-programs']))
                                            <th>
                                                <a class="btn m-btn--pill m-btn--air btn-secondary table-middle" id="add_program_a" data-toggle="m-tooltip" data-placement="left" data-original-title="{{ __('Add new') }}">
                                                    <i class="flaticon-add"></i>
                                                </a>
                                            </th>
                                        @else
                                            <th>{{ __('Action') }}</th>
                                        @endif
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="add_program_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Add Program') }}</h5>
                    {!! Form::button('<span aria-hidden="true">&times;</span>', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) !!}
                </div>

                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'id' => 'add_program_form', 'name' => 'add_program_form']) !!}

                        <div class="form-group">
                            {!! Form::label(__('Name Program'), null, ['for' => 'recipient-name', 'class' => 'form-control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name']) !!}
                        </div>

                    {!! Form::close() !!}
                </div>

                <div class="modal-footer">
                    {!! Form::button(__('Close'), ['type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button(__('Create'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'add_program_btn']) !!}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="edit_program_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit program') }}</h5>
                    {!! Form::button('<span aria-hidden="true">&times;</span>', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) !!}
                </div>

                <div class="modal-body">
                    {!! Form::open(['method' => 'POST', 'id' => 'edit_program_form', 'name' => 'edit_program_form']) !!}
                        {!! Form::hidden('_method', 'PUT') !!}
                        {!! Form::hidden('program_id', null, ['id' => 'program_id']) !!}

                        <div class="form-group">
                            {!! Form::label(__('Name Program'), null, ['for' => 'recipient-name', 'class' => 'form-control-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'edit_name']) !!}
                        </div>
                        
                    {!! Form::close() !!}
                </div>

                <div class="modal-footer">
                    {!! Form::button(__('Close'), ['type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                    {!! Form::button(__('Save'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'edit_program_btn']) !!}
                </div>
            </div>
        </div>
    </div>

    {!! Form::hidden('processing_lang', __('Processing'), ['id' => 'processing_lang']) !!}
    {!! Form::hidden('required_lang', __('Required'), ['id' => 'required_lang']) !!}
    {!! Form::hidden('program_name_lang', __('Name Program'), ['id' => 'program_name_lang']) !!}
    {!! Form::hidden('add_success_lang', __('Add success'), ['id' => 'add_success_lang']) !!}
    {!! Form::hidden('edit_success_lang', __('Edit success'), ['id' => 'edit_success_lang']) !!}
    {!! Form::hidden('question_delete_lang', __('Question delete'), ['id' => 'question_delete_lang']) !!}
    {!! Form::hidden('delete_success_lang', __('Delete success'), ['id' => 'delete_success_lang']) !!}
    {!! Form::hidden('yes_lang', __('Yes'), ['id' => 'yes_lang']) !!}
    {!! Form::hidden('no_lang', __('No'), ['id' => 'no_lang']) !!}
    {!! Form::hidden('edit_lang', __('Edit'), ['id' => 'edit_lang']) !!}
    {!! Form::hidden('delete_lang', __('Delete'), ['id' => 'delete_lang']) !!}

@endsection

@section('js')
    <script src="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('bower_components/metro-asset/demo/default/custom/crud/datatables/data-sources/html.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/toastr.min.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>

    @routes
    <script src="{{ mix('js/program.js') }}"></script>
@endsection
