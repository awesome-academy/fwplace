@extends('admin.layout.master')

@section('title', __('Employee Disable'))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/sweet-alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/datatable.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Employee Disable') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Employee') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Employee Disable') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    {{ link_to_route('batches.create', $title = __('Add'), $parameters = [], $attributes = ['class' => 'btn btn-success mb-2']) }}
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table m-table m-table--head-bg-primary">
                                <thead>
                                    <tr>
                                        <th>{{ trans('Batch') }}</th>
                                        <th>{{ trans('Start day') }}</th>
                                        <th>{{ trans('Stop day') }}</th>
                                        <th>{{ trans('Workspace') }}</th>
                                        <th>{{ trans('Program') }}</th>
                                        <th>{{ trans('Position') }}</th>
                                        <th>{{ trans('Created_at') }}</th>
                                        <th>{{ trans('ShortHand') }}</th>
                                        <th>{{ trans('Action') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @if(isset($batches))
                                        @foreach($batches as $key => $batch)
                                            @if (Auth::user()->role == config('site.permission.admin') || $user->role != config('site.permission.admin'))

                                                <tr role="row" class="odd" >
                                                    <td>{{ $batch->batch }}</td>
                                                    <td>{{ $batch->start_day }}</td>
                                                    <td>{{ $batch->stop_day }}</td>
                                                    <td>{{ $batch->workspace->name }}</td>
                                                    <td>{{ $batch->program->name }}</td>
                                                    <td>{{ $batch->position->name }}</td>
                                                    <td>{{ $batch->created_at }}</td>
                                                    <td>{{ $batch->workspace->name . ' - ' . $batch->program->name . ' - ' . $batch->position->name . ' - ' . $batch->batch }}</td>

                                                    <td>
                                                        <a href="{{ route('batches.edit', ['id' => $batch->id]) }}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" data-toggle="m-tooltip" data-placement="top" data-original-title="{{ __('Edit') }}"><i class='flaticon-edit-1'></i></a>
                                                        {{ Form::open(['route' => ['batches.destroy', 'id' => $batch->id ], 'method' => 'DELETE']) }}
                                                            {!! Form::button('<i class="flaticon-cancel"></i>', [
                                                                'class' => 'delete btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill',
                                                                'type' => 'submit',
                                                                'message' => __('Delete this item?')
                                                            ]) !!}
                                                        {{ Form::close() }}
                                                    </td>
                                                </tr>

                                            @endif
                                        @endforeach
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/active_user.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>
@endsection
