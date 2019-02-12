@extends('admin.layout.master')

@section('title', __('Add Location'))

@section('module', __('Add Location'))

@section('content')
<div class="btn btn-success mb-2" id="show-form">{{ __('Create special day') }}</div>
<div class="btn btn-info mb-2" id="hide-form">{{ __('Hide Form') }}</div>
<div class="m-portlet" id="special-day-form">
    <div class="p-3">
        @forelse($errors->all() as $error)
            @include('admin.components.alert', ['type' => 'danger', 'message' => $error])
        @endforeach
    </div>
    <!--begin::Form-->
    {!! Form::open([
        'route' => 'special-days.store', 
        'method' => 'POST', 
        'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator',
    ]) !!}

        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                {!! Form::label(null, __('Title'), ['class' => 'col-lg-2 col-form-label']) !!}
                <span class="text-danger">*</span>
                <div class="col-lg-9">
                    {!! Form::text('title', null, ['class' => 'form-control m-input', 'placeholder' => ('Special Day')]) !!}
                </div>
            </div>
            <div class="form-group m-form__group row">
                {!! Form::label(null, __('From'), ['class' => 'col-lg-2 col-form-label']) !!}
                <span class="text-danger">*</span>
                <div class="col-lg-3">
                    {!! Form::date('from', null, ['class' => 'form-control m-input', 'placeholder' => ('From'), 'min' => 1]) !!}
                </div>
                {!! Form::label(null, __('To'), ['class' => 'col-lg-2 col-form-label']) !!}
                <span class="text-danger">*</span>
                <div class="col-lg-3">
                    {!! Form::date('to', null, ['class' => 'form-control m-input', 'placeholder' => ('From'), 'min' => 1]) !!}
                </div>
            </div>
            <h3 class="ml-5 mt-3 border-bottom col-md-10">{{ trans('Compensation') }}</h3>
            <div class="form-group m-form__group row">
                {!! Form::label(null, __('From'), ['class' => 'col-lg-2 col-form-label']) !!}
                <span class="text-danger">*</span>
                <div class="col-lg-3">
                    {!! Form::date('compensation_from', null, ['class' => 'form-control m-input', 'placeholder' => ('From'), 'min' => 1]) !!}
                </div>
                {!! Form::label(null, __('To'), ['class' => 'col-lg-2 col-form-label']) !!}
                <span class="text-danger">*</span>
                <div class="col-lg-3">
                    {!! Form::date('compensation_to', null, ['class' => 'form-control m-input', 'placeholder' => ('From'), 'min' => 1]) !!}
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-2"></div>
                    <div class="col-lg-6">
                        {!! Form::submit(__('Save'), ['class' => 'btn btn-success']) !!}
                        {!! Form::button(__('Cancel'), ['type' => 'reset', 'class' => 'btn btn-secondary']) !!}
                    </div>
                </div>
            </div>
        </div>
    {!! Form::close() !!}

    <!--end::Form-->
</div>
<div id="calendar" class="col-xs-12 calendar"></div>
@endsection

@section('js')
<script src="{{ asset('bower_components/bootstrap-year-calendar/js/bootstrap-year-calendar.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-year-calendar/css/bootstrap-year-calendar.css') }}">
<script type="text/javascript" src="{{ asset('js/calendarDateTime.js') }}"></script>
@endsection
