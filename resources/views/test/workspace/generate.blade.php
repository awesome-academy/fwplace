@extends('admin.layout.master')

@section('title', __('Add Workspace'))
@section('css')
    <link rel="stylesheet" href="{{ asset('css/addlocation.css') }}">
@endsection
@section('module', __('Add Workspace'))

@section('content')
<div class="m-portlet pl-5 py-5">
    <div class="workspace">
        <div class="p-3">
            @forelse($errors->all() as $error)
                @include('admin.components.alert', ['type' => 'danger', 'message' => $error])
            @endforeach
        </div>
        <div class="form-workspace">
            {!! Form::open(['url' => route('save_location', ['id' => $idWorkspace]), 'method' => 'POST']) !!}
                <p id="list-seat"></p>
                {!! Form::hidden('seats', null, ['id' => 'seats']) !!}
                {!! Form::text('name', null, ['placeholder' => __('Name')]) !!}
                {!! Form::color('color', null, ['placeholder' => __('Color')]) !!}
                {!! Form::submit(__('Save'), ['class' => 'btn btn-success']) !!}
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
                            <span seat_id="" avatar="" program="" position="" user_id="" class="seat @if ($seat === null) disabled @endif" id="{{ $seat }}">
                                {{ $seat ?? 'X' }}
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
            <h4 class="modal-title">{{ __('Information user') }}</h4>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center login-header clearfix">
                                {!! Html::image( asset(config('site.static') . 'favicon.png'), 'alt' ) !!}
                                <p></p>
                            </div>
                            {!! Form::open([ 'method' => 'POST', 'route' => 'save_info_location','files' => true, 'class'=>'m-form m-form--fit'] ) !!}
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
                                        {!! htmlspecialchars_decode( Form::label( 'name', __('User Name').'<span class="required">*</span>', [ 'class' => 'control-label col-md-4 col-sm-4 col-xs-12']  ) )  !!}
                                        <div class="col-8">
                                            {!! Form::select('user_id[]',$listUser, null, ['class' => 'form-control m-input', 'required'=>'', 'id' => 'list-name', 'placeholder' => 'User - Name' ])  !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode( Form::label( 'language', __('Language').'<span class="required">*</span>', [ 'class' => 'control-label col-md-4 col-sm-4 col-xs-12']  ) )  !!}
                                        <div class="col-8">
                                            {!! Form::select('language',$listProgram, null, ['class' => 'form-control m-input', 'id' => 'list-language'])  !!}
                                        </div>
                                    </div>
                                    <div class="form-group m-form__group row">
                                        {!! htmlspecialchars_decode( Form::label( 'position', __('Position').'<span class="required">*</span>', [ 'class' => 'control-label col-md-4 col-sm-4 col-xs-12']  ) )  !!}
                                        <div class="col-8">
                                            {!! Form::select('position',$listPosition, null, ['class' => 'form-control m-input', 'id' => 'list-position'])  !!}
                                        </div>
                                    </div>
                                    {!! Form::hidden('seat_id','', ['id' => 'locations']) !!}
                                </div>
                                <div class="boder"></div>
                                {!! Form::submit(__('Save'), ['class' => 'col-md-12 btn btn-success']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>

@endsection
@section('js')
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="js/config.js"></script>
    <script src="{{ asset('js/generate.js') }}"></script>
@endsection
