@extends('admin.layout.master')
@section('title', __('Register Work Schedules') )
@section('module', __('Register Work Schedules'))
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Day'), ['class' => 'col-form-label col-lg-3']) !!}
                                            </div>
                                        </th>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Day of Week'), ['class' => 'col-form-label col-lg-8']) !!}
                                            </div>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Shift'), ['class' => 'col-form-label col-md-6 text-center']) !!}
                                            <div class="col-md-6">
                                            {!! Form::select('shift', [config('site.shift.off') => __('Off'), config('site.shift.all') => __('All day'), config('site.shift.morning') => __('Morning'), config('site.shift.afternoon') => __('Afternoon') ], null, ['class' => 'form-control', 'id'=> 'select_shift']) !!}
                                            </div>
                                            </div>
                                        </th>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Location'), ['class' => 'col-form-label col-lg-6 text-center']) !!}
                                            <div class="col-lg-6">
                                                {!! Form::select('location_id', [config('site.default_location') => __('--Choose--')] + $locations, null, ['class' => 'form-control', 'id' => 'select_location']) !!}
                                            </div>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                {!! Form::open(['url' => route('workschedule'), 'method' => 'post' , 'id' => 'add_form' , 'enctype' => 'multipart/form-data']) !!}
                                <tbody>
                                    @php
                                        $today = Date('d-m-Y H:i:s');
                                        $shifts = [
                                            config('site.shift.off') => __('Off'),
                                            config('site.shift.all') => __('All day'),
                                            config('site.shift.morning') => __('Morning'),
                                            config('site.shift.afternoon') => __('Afternoon'),
                                        ];
                                        $test = [];
                                    @endphp
                                    @foreach($dates as $day)
                                    <tr
                                        @if(isset($day['weekend']))
                                            class="bg-secondary text-dark"
                                        @endif
                                        id="{{ $day['date'] }}"
                                        onload="getSpecialDay({{ json_encode($day) }})"
                                    >
                                            <th scope="row">{{ $day['format'] }}</th>
                                            <td id="{{ $day['date'] . '2' }}">{{ __($day['day']) }}</td>
                                            @if($day['format'] >= $today)
                                                <td>
                                                    @if(!isset($day['weekend']))
                                                        {!! Form::select('shift[' . $day['date']  .  ']', $shifts, $data[$day['date']] ?? null, ['class' => 'form-control tar', 'id' => 'sl_shift']) !!}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if(!isset($day['weekend']))
                                                        {!! Form::select('location[' . $day['date']  .  ']', [config('site.default_location') => __('--Choose--')] + $locations, $dataLocation[$day['date']] ?? null, ['class' => 'form-control target', 'id' => 'sl_location']) !!}
                                                    @endif
                                                </td>
                                            @else
                                                <td class="text-center">{{ isset($data[$day['date']]) ? $data[$day['date']] : '' }}</td>
                                                <td class="text-center">{{ isset($dataLocation[$day['date']]) ? $dataLocation[$day['date']] : '' }}</td>
                                            @endif
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="m-form m-form--fit m-form--label-align-right">
                                {!! Form::submit(__('Save') . '!', ['class' => 'btn m-btn--pill    btn-primary btn-lg m-btn m-btn--custom']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script type="text/javascript" src="{{ asset('js/special_day.js') }}"></script>
<script src="{{ asset('js/register_work_schedules.js') }}"></script>
@endsection
