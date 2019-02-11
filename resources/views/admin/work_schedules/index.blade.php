@extends('admin.layout.master')

@section('title', 'Schedules')

@section('content')
<div class="bg-light p-3">
    <h3 class="text-center font-weight-bold">{{ __('Work Schedule Of Month ') . Date('m') . '-' . Date('Y') }}</h3>
    <div class="schedule-filter">
        {!! Form::open(['method' => 'get', 'url' => route('schedule.index'), 'id' => 'form-filter']) !!}
        <div class="col-md-3 d-inline-block">
            <div class="form-group row">
                <label for="program" class="col-form-label">{{ __('Program') }}</label>
                <div class="col-md-7">
                    {!! Form::select('program', ['' => __('All')] + $programs, Request::get('program'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-3 d-inline-block">
            <div class="form-group row">
                <label for="position" class="col-form-label">{{ __('Position') }}</label>
                <div class="col-md-9">
                    {!! Form::select('position', ['' => __('All')] + $positions, Request::get('position'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-3 d-inline-block">
            <div class="form-group row">
                <label for="workspace" class="col-form-label">{{ __('Workspace') }}</label>
                <div class="col-md-9">
                    {!! Form::select('workspace', ['' => __('All')] + $workspaces, Request::get('workspace'), ['class' => 'form-control']) !!}
                </div>
            </div>
        </div>
        <div class="col-md-2 d-inline-block">
            <button class="btn btn-success" type="button" id="submit-filter">{{ __('Fill') }}</button>
            <button class="btn btn-primary" type="button" id="export">{{ __('Export') }}</button>
        </div>
        {!! Form::close() !!}
    </div>
    @if(count($users) > 0)
    <div class="w-100">
        <div class="float-left w-25 left-schedule">
            <table class="w-100">
                <thead>
                    <tr class="left-row">
                        <th class="text-center">{{ __('Num.') }}</th>
                        <th class="text-center">{{ __('Fullname') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $num = 1;
                    @endphp
                    @foreach ($users as $user)
                        <tr class="left-row">
                            <td class="text-center">{{ $num++ }}</td>
                            <td class="word-break-all">{{ $user->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="float-left w-75 right-schedule">
            <table class="right-table">
                <thead>
                    <tr class="right-row">
                        <th class="text-center col-min-3">{{ __('Position') }}</th>
                        <th class="text-center col-min-2">{{ __('University') }}</th>
                        <th class="text-center col-min-3">{{ __('Office') }}</th>
                        @for($i = 1; $i <= Date('t'); $i++)
                            <th class="col-md-1 text-center">{{ $i }}</th>
                        @endfor
                        <th class="text-center col-md-1">W</th>
                        <th class="text-center col-md-1">M</th>
                        <th class="text-center col-md-1">A</th>
                        <th class="text-center col-md-1">X</th>
                        <th class="text-center col-min-2">{{ __('Work Days') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        @php
                            $count = [];
                            for($i = 0; $i < 4; $i++) {
                                $count[$i] = 0;
                            }
                        @endphp
                        <tr class="right-row">
                            <td class="word-break-all">{{ $user->position->name . ' ' . $user->program->name }}</td>
                            <td class="word-break-all">{{ $user->school }}</td>
                            <td class="word-break-all">{{ $user->workspace->name }}</td>
                            @for($i = 1; $i <= Date('t'); $i++)
                                @php
                                    $date = $i . '-' . Date('n') . '-' . Date('Y');
                                @endphp
                                @if(isset($user->schedules[$i]))
                                    <td data-date="{{ $date }}" class="text-center {{ (Date('N', strtotime($date)) >= 6) ? 'bg-danger' : '' }}">{{ config('api.status.short.' . $user->schedules[$i]->shift) }}</td>
                                    @php($count[$user->schedules[$i]->shift]++)
                                @else
                                    <td data-date="{{ $date }}" class="{{ (Date('N', strtotime($date)) >= 6) ? 'bg-danger' : '' }}"></td>
                                @endif
                            @endfor
                            <td class="text-center">{{ $count[1] }}</td>
                            <td class="text-center">{{ $count[2] }}</td>
                            <td class="text-center">{{ $count[3] }}</td>
                            <td class="text-center">{{ $count[0] }}</td>
                            <td class="text-center">{{ $count[1] + ($count[2] + $count[3]) * 0.5 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-3">
        <table class="col-md-2">
            @for($i = 0; $i < 4; $i++)
                <tr>
                    <td>{{ __(config('api.status.' . $i)) }}</td>
                    <td class="text-center">{{ config('api.status.short.' . $i) }}</td>
                </tr>
            @endfor
        </table>
    </div>
    @else
        <div>
            <h4 class="text-center p-5">{{ __('No Data') }}</h4>
        </div>
    @endif
</div>
@endsection

@section('js')
    <script src="{{ asset('js/schedules.js') }}"></script>
@endsection
