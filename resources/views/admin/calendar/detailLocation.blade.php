@extends('admin.layout.master')

@section('title', __('Work Schedule'))

@section('module', __('Detail') . ' ' . $date)

@section('css')
    {{ Html::style('bower_components/datatables.net-dt/css/jquery.dataTables.css') }}
@endsection

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__body">
            <div class="m-section">
                <div class="m-section__content">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <span class="m-portlet__head-icon">
                                    <i class="flaticon-map-location"></i>
                                </span>
                                <h3 class="m-portlet__head-text">
                                    {{ $location->name }}
                                    -
                                    @lang('Total Seat:', ['total' => $location->seats()->count()])
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        {!! Form::hidden('', $location->id, ['id' => 'location-id']) !!}
                        {!! Form::hidden('', $date, ['id' => 'date']) !!}
                        {!! Form::open(['class' => 'row mb-3', 'method' => 'GET']) !!}
                        <div class="col-md-4 offset-md-2">
                            {!! Form::select('shift', config('site.shift_filter'), request('shift'), ['class' => 'form-control m-input m-input--square', 'id' => 'program']) !!}
                        </div>
                        <div class="col-md-4">
                            {!! Form::select(
                                'program_id',
                                [config('site.default_location') => __('--Choose--')] + $programs,
                                request('program_id'),
                                ['class' => 'form-control m-input m-input--square', 'id' => 'program'])
                            !!}
                        </div>
                        <div class="col-md-2">
                            {!! Form::submit(__('Apply'), ['class' => 'btn btn-brand w-100']) !!}
                        </div>
                        {!! Form::close() !!}
                        <div class="m-portlet__body">
                            <div class="m-section">
                                <div class="m-section__content" id="load-ajax">
                                    <table class="table m-table m-table--head-bg-success" id="user-table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ trans('Email') }}</th>
                                            <th>{{ trans('Program') }}</th>
                                            <th>{{ trans('Position') }}</th>
                                            <th>{{ trans('Working Time') }}</th>
                                            <th>{{ trans('Role') }}</th>
                                            <th>{{ trans('Shift') }}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse ($data as $key => $user)
                                            <tr role="row" class="odd">
                                                <td class="sorting_1" tabindex="0">
                                                    <div class="m-card-user m-card-user--sm">
                                                        <div class="m-card-user__pic">
                                                            <div class="m-card-user__no-photo m--bg-fill-danger">
                                                                <span>
                                                                    {!! Html::image($user->avatarUser) !!}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="m-card-user__details">
                                                            <span class="m-card-user__name">
                                                                <a href="{{ route('schedule.detail.location', $user->id) }}">{{ $user->name }}</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->program->name }}</td>
                                                <td>{{ $user->position->name }}</td>
                                                <td>{{ $user->position->is_fulltime == config('site.partime') ? __('Partime') : __('Fulltime') }}</td>
                                                @if ($user->role == config('site.permission.trainee'))
                                                    <td>{{ trans('Trainee') }}</td>
                                                @elseif ($user->role == config('site.permission.trainer'))
                                                    <td>{{ trans('Trainer') }}</td>
                                                @else
                                                    <td>{{ trans('Admin') }}</td>
                                                @endif
                                                <td>
                                                    <span class="btn btn-primary">{{ $user->getShiftByDate($date) }}</span>
                                                </td>
                                            </tr>
                                        @empty
                                            @include('admin.components.alert', ['type' => 'warning', 'message' => __('Have no data!')])
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    {{ Html::script('bower_components/datatables.net/js/jquery.dataTables.js') }}
    <script>
        $(document).ready( function () {
            $('#user-table').DataTable();
        } );
    </script>
@endsection
