@extends('admin.layout.master')

@section('title', __('Add Workspace'))

@section('css')
    {{ Html::style(asset('css/addlocation.css')) }}
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Edit Workspace') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Model Workspace') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a href="{{ route('list_workspace') }}" class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Workspace List') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Edit Workspace') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')
<div class="m-portlet pl-5 py-5">
    <div class="workspace">
        <div class="p-3">
            @forelse($errors->all() as $error)
                @include('admin.components.alert', ['type' => 'danger', 'message' => $error])
            @empty
            @endforelse
        </div>
        <div class="col-md-4 form-workspace">
            {!! Form::open(['url' => route('save_location', ['id' => $idWorkspace]), 'method' => 'POST', 'class' => 'm-form m-form--fit m--margin-bottom-20']) !!}
                <div class="row">
                    <p id="list-seat"></p>
                    {!! Form::hidden('seats', null, ['id' => 'seats']) !!}
                    {!! Form::text('name', null, ['placeholder' => __('Name'), 'class' => 'form-control m-input col-md-6']) !!}
                    {!! Form::color('color', null, ['placeholder' => __('Color'), 'id' => 'input-color']) !!}
                    <div class="col-md-2">
                        {!! Form::label('usable', __('Usable')) !!}
                        {!! Form::checkbox('usable', config('site.default.usable'), false, ['class' => 'form-control m-input col-md']) !!}
                    </div>
                    {!! Form::submit(__('Save'), ['class' => 'btn btn-success form-control m-input col-md-2']) !!}
                </div>
            {!! Form::close() !!}
        </div>
        {!! Form::button(__('Add location'), ['class' => 'btn btn-success', 'id' => 'show']) !!}
        <div id="noteaddlocation">
            <p>@lang('Note*: Please select location before click button Add location')</p>
        </div>
        <div class="all_seat">
            {!! Form::hidden('',$colorLocation, ['id' => 'colorLocation']) !!}
            @foreach($renderSeat as $row)
                <div class="row">
                    @foreach($row as $seat)
                        <a data-toggle="modal" href='#modal-info-user'  class="register-info-user">
                            <span seat_id="" avatar="" program="" position="" user_id="" class="seat {{ $seat === null ? 'disabled' : '' }}" id="{{ $seat }}">
                                <span class="seat-name">{{ $seat ?? 'X' }}</span>
                            </span>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
@include('test.workspace.modal_info_user_1')
<div class="modal fade" id="modal-info-user">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="text-center mb-3">
                <div class="seat-options btn btn-light selected col-md-5">
                    <span>{{ __('Register Seat') }}</span>
                </div>
                <div class="seat-options btn btn-light col-md-5">
                    <span>{{ __('Edit Seat') }}</span>
                </div>
            </div>
            <div class="option-view">
                <h4 class="modal-title">{{ __('Information user') }}</h4>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!! Form::open(['method' => 'POST', 'route' => 'save_info_location', 'files' => true, 'class'=>'m-form m-form--fit']) !!}
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group row">
                                        <div class="col-12">
                                            <div class="container-img">
                                                <div class="avatar-upload">
                                                    <div class="avatar-edit">
                                                        {!! Form::file('avatar', ['accept' => '.png, .jpg, .jpeg', 'id' => 'imageUpload']) !!}
                                                    </div>
                                                    <div class="avatar-preview">
                                                        <div id="imagePreview">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode(Form::label('name', __('User Name').'<span class="required">*</span>', ['class' => 'control-label col-md-4 col-sm-4 col-xs-12'])) !!}
                                        <div class="col-8">
                                            {!! Form::select('user_id[]', $listUser, null, ['class' => 'form-control m-input', 'required'=>'', 'id' => 'list-name', 'placeholder' => 'User - Name']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode(Form::label('language', __('Language').'<span class="required">*</span>', ['class' => 'control-label col-md-4 col-sm-4 col-xs-12'])) !!}
                                        <div class="col-8">
                                            {!! Form::select('language', $listProgram, null, ['class' => 'form-control m-input', 'id' => 'list-language']) !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode(Form::label('position', __('Position').'<span class="required">*</span>', ['class' => 'control-label col-md-4 col-sm-4 col-xs-12'])) !!}
                                        <div class="col-8">
                                            {!! Form::select('position', $listPosition, null, ['class' => 'form-control m-input', 'id' => 'list-position']) !!}
                                        </div>
                                    </div>
                                    {!! Form::hidden('seat_id', '', ['id' => 'locations']) !!}
                                </div>
                                <div class="boder"></div>
                                {!! Form::submit(__('Save'), ['class' => 'col-md-5 btn btn-success']) !!}
                                <button class="col-md-offset-2 btn btn-danger" data-dismiss="modal">{{ __('Delete Cell') }}</button>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="option-view d-none">
                <h1 class="modal-title">{{ __('Edit Location') }}</h1>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-12">
                            {!! Form::open(['method' => 'POST', 'route' => 'edit_seat', 'class' => 'form-horizontal']) !!}
                            <div class="form-group row">
                                {!! Form::label('color', __('Color'), ['class' => 'col-md-3']) !!}
                                <div class="col-md-5">
                                    {!! Form::color('color', null, ['placeholder' => __('Color')]) !!}
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-3"></div>
                                <div class="col-md-3">
                                    {!! Form::submit('Submit', ['class' => 'btn btn-success']) !!}
                                </div>
                            </div>
                            {!! Form::hidden('seat_id', '', ['class' => 'locations']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
    {{ Html::script(asset('js/jquery-ui.js')) }}
    {{ Html::script(asset('js/config.js')) }}
    {{ Html::script(asset('js/generate.js')) }}
    {{ Html::script(asset('js/edit_location.js')) }}
@endsection
