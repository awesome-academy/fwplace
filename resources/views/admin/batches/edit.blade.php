@extends('admin.layout.master')
@section('title', __('Employee'))
@section('module')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Employee') }}</h3>
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="{{ url('admin') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">-</li>
            <li class="m-nav__item">
                <a href="{{ url('admin/batchs') }}" class="m-nav__link">
                    <span class="m-nav__link-text">{{ __('Employee') }}</span>
                </a>
            </li>
            <li class="m-nav__separator">-</li>
            <li class="m-nav__item">
                <span class="m-nav__link-text">{{ __('Edit Employee') }}</span>
            </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="m-portlet" data-select2-id="5">
        <div class="m-portlet__head">
            <div class="m-portlet__head-caption">
                <div class="m-portlet__head-title">
                    <h3 class="m-portlet__head-text">
                        {{ __('Edit batch') }}
                    </h3>
                </div>
            </div>
        </div>
        {!! Form::model($batch, ['url' => 'admin/batches/' . $batch->id, 'method' => 'PUT', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed', 'files' => true]) !!}
        {!! Form::hidden('id', $batch->id) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Start day')) !!}
                    {!! Form::date('start_daty', $batch->start_day, ['class' => 'form-control m-input', 'placeholder' => __('Enter Start day')]) !!}
                    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                    <span class="m-form__help">{{ __('Please enter Start day') }}</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Stop day')) !!}
                    {!! Form::date('stop_day', $batch->start_day, ['class' => 'form-control m-input', 'placeholder' => __('Enter Stop day')]) !!}
                    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                    <span class="m-form__help">{{ __('Please enter Stop day') }}</span>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Batch')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {{ Form::number('batch', $batch->batch, ['class' => 'form-control m-input']) }}
                    </div>
                    <span class="m-form__help">{{ trans('Please select Status') }}</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Program')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('program_id', $programs, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    <span class="m-form__help">{{ __('Please select Program') }}</span>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Position')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('position_id', $positions, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    <span class="m-form__help">{{ __('Please select Position') }}</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Workspace')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('workspace_id', $workspaces, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    <span class="m-form__help">{{ __('Please select Workspace') }}</span>
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-6">
                        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                        <a href="{{ url('admin/batchs') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                    <div class="col-lg-6 m--align-right">
                        {!! Form::reset(__('Reset'), ['class' => 'btn btn-danger']) !!}
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection
