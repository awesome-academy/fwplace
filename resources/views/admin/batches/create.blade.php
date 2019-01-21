@extends('admin.layout.master')
@section('title', __('Batches'))
@section('module')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Batches') }}</h3>
        <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
            <li class="m-nav__item m-nav__item--home">
                <a href="{{ url('admin') }}" class="m-nav__link m-nav__link--icon">
                    <i class="m-nav__link-icon la la-home"></i>
                </a>
            </li>
            <li class="m-nav__separator">-</li>
            <li class="m-nav__item">
                <a href="{{ url('admin/batchs') }}" class="m-nav__link">
                    <span class="m-nav__link-text">{{ __('Batches') }}</span>
                </a>
            </li>
            <li class="m-nav__separator">-</li>
            <li class="m-nav__item">
                <span class="m-nav__link-text">{{ __('Create Batch') }}</span>
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
        {!! Form::open(['url' => route('batches.store'), 'method' => 'POST', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed']) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Start day')) !!}
                    {!! Form::date('start_day', null, ['class' => 'form-control m-input', 'placeholder' => __('Enter Start day')]) !!}
                    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                    @if($errors->has('start_day'))
                        <span class="m-form__help text-danger">{{ __('Please enter Start day') }}</span>
                    @endif
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Stop day')) !!}
                    {!! Form::date('stop_day', null, ['class' => 'form-control m-input', 'placeholder' => __('Enter Stop day')]) !!}
                    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                    @if($errors->has('stop_day'))
                        <span class="m-form__help text-danger">{{ __('Please enter Stop day') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Subjects')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {{ Form::select('subjects[]', $subjects, null, [
                                'id' => 'select_subject',
                                'class' => 'form-control m-input',
                                'multiple' => 'multiple',
                            ]
                        ) }}
                    </div>
                    @if($errors->has('subjects'))
                        <span class="m-form__help text-danger">{{ trans('Please select subject') }}</span>
                    @endif
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Program')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('program_id', ['' => __('Choose Program')] + $programs, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    @if($errors->has('program_id'))
                        <span class="m-form__help text-danger">{{ __('Please select Program') }}</span>
                    @endif
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Position')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('position_id', ['' => __('Choose Position')] + $positions, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    @if($errors->has('position_id'))
                        <span class="m-form__help text-danger">{{ __('Please select Position') }}</span>
                    @endif
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Workspace')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('workspace_id', ['' => __('Choose Workspace')] + $workspaces, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    @if($errors->has('workspace_id'))
                        <span class="m-form__help text-danger">{{ __('Please select Workspace') }}</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-6">
                        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                        <a href="{{ route('batches.index') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
                    </div>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/select_subject.js') }}"></script>
@endsection
