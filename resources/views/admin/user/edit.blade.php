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
                <a href="{{ url('admin/users') }}" class="m-nav__link">
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
                        {{ __('Edit User') }}
                    </h3>
                </div>
            </div>
        </div>
        {!! Form::model($user, ['url' => 'admin/users/' . $user->id, 'method' => 'PATCH', 'class' => 'm-form m-form--fit m-form--label-align-right m-form--group-seperator-dashed', 'files' => true]) !!}
        {!! Form::hidden('id', $user->id) !!}
        <div class="m-portlet__body">
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Full Name')) !!}
                    {!! Form::text('name', $user->name, ['class' => 'form-control m-input', 'placeholder' => __('Enter full Name')]) !!}
                    {!! $errors->first('name', '<p class="text-danger">:message</p>') !!}
                    <span class="m-form__help">{{ __('Please enter Full Name') }}</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Email')) !!}
                    {!! Form::email('email', null, ['class' => 'form-control m-input', 'placeholder' => __('Enter Email')]) !!}
                    {!! $errors->first('email', '<p class="text-danger">:message</p>') !!}
                    <span class="m-form__help">{{ __('Please enter Email') }}</span>
                </div>
            </div>
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Program')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('program_id', $programs, null, ['class' => 'form-control m-input']) !!}
                    </div>
                    <span class="m-form__help">{{ __('Please select Program') }}</span>
                </div>
                <div class="col-lg-6">
                    {!! Form::label(__('Status')) !!}
                    <div class="m-input-icon m-input-icon--right">
                        {!! Form::select('status', [config('site.disable') => __('Disable'), config('site.active') => __('Active') ], $user->status, ['class' => 'form-control m-input']) !!}
                    </div>
                    <span class="m-form__help">{{ trans('Please select Status') }}</span>
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
            @if (Auth::user()->role == config('site.permission.admin') && $user->role != config('site.permission.admin'))
                <div class="form-group m-form__group row">
                    <div class="col-lg-6">
                        {!! Form::label(__('Batches')) !!}
                        <div class="m-input-icon m-input-icon--right">
                            {!! Form::select('batch_id', $batches, null, ['class' => 'form-control m-input']) !!}
                        </div>
                        <span class="m-form__help">{{ trans('Please select Role') }}</span>
                    </div>
                </div>
            @endif
            
            <div class="form-group m-form__group row">
                <div class="col-lg-6">
                    {!! Form::label(__('Avatar')) !!}
                    <div class="custom-file">
                        {!! Form::file('avatar', ['class' => 'custom-file-input', 'id' => 'input-display']) !!}
                        {!! Form::label(__('Choose file'), null, ['class' => 'custom-file-label']) !!}
                        {!! $errors->first('avatar', '<p class="text-danger">:message</p>') !!}
                    </div>
                    <img src="" alt="" id="image-display" class="w-50">
                </div>
            </div>
        </div>
        <div class="m-portlet__foot m-portlet__no-border m-portlet__foot--fit">
            <div class="m-form__actions m-form__actions--solid">
                <div class="row">
                    <div class="col-lg-6">
                        {!! Form::submit(__('Save'), ['class' => 'btn btn-primary']) !!}
                        <a href="{{ url('admin/users') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
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
