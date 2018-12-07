@extends('admin.layout.master')

@section('title', __('Register Seat'))
@section('css')
    {{ Html::style('css/addlocation.css') }}
@endsection
@section('module', __('Modeling Workspace'))

@section('content')
    <div class="m-portlet pl-5 py-5">
        <div class="workspace">
            <div class="p-3">
                @forelse ($errors->all() as $error)
                    @include('admin.components.alert', ['type' => 'danger', 'message' => $error])
                @empty
                @endforelse
            </div>
            <div id="noteaddlocation">
            </div>
            <div class="row">
                <div class="col-md-5"></div>
                <div class="col-md-3 col-md-offset-1">
                    <div class="your-seat">
                        {!! Form::hidden('', $seatOfUser, ['id' => 'seat-of-user']) !!}
                        <p id="shift-user"></p>
                    </div>
                </div>
                <div class="col-md-3 col-md-offset-8">
                    <div class="day">
                        {!! Form::select('day', $dates, null, ['class' => 'form-control', 'id' => 'select-day']) !!}
                    </div>
                </div>
            </div>
            <div class="all_seat">
                {!! Form::hidden('', $colorLocation, ['id' => 'color-location']) !!}
                {!! Form::hidden('', Auth::user()->position_id, ['id' => 'user-position']) !!}
                {!! Form::hidden('', $schedules, ['id' => 'schedules']) !!}
                {!! Form::hidden('', $workspace->id, ['id' => 'get-workspace-id']) !!}
                @foreach($renderSeat as $row)
                    <div class="row">
                        @foreach($row as $seat)
                            <a data-toggle="modal" href='#register-seat-modal' class="disabled text-dark">
                                <span data-seat_id="" class="nor-seat {{ $seat === null ? 'disabled' : '' }}" id="{{ $seat }}">
                                    {{ $seat ?? 'X' }}
                                </span>
                            </a>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="register-seat-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <h4 class="modal-title">{{ __('Seat Information') }}</h4>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center login-header clearfix">
                                {!! Html::image(asset(config('site.static') . 'favicon.png'), 'alt') !!}
                                <p></p>
                            </div>
                            {!! Form::open(['route' => 'user.register.seat', 'class'=>'m-form m-form--fit', 'id' => 'register-seat-form']) !!}
                            <div class="m-portlet__body">
                                <div class="row">
                                    <div class="col-md text-center">
                                        <p id="day-registered"></p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md text-center">
                                        <p id="seat-name"></p>
                                    </div>
                                </div>
                            </div>
                            {!! Form::hidden('day', '', ['id' => 'day_registered']) !!}
                            {!! Form::hidden('seat_id','', ['id' => 'seat-id-registered']) !!}
                            {!! Form::hidden('shift', '', ['id' => 'shift-registered']) !!}
                            {!! Form::hidden('cur_seat', '', ['id' => 'cur-seat']) !!}
                        </div>
                        <div class="boder"></div>
                            {!! Form::submit(__('Register'), ['class' => 'col-md-12 btn btn-success']) !!}
                            {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{ Html::script('js/jquery-ui.js') }}
    {{ Html::script('js/register_seat.js') }}
@endsection
