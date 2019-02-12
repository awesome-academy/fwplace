@extends('admin.layout.master')

@section('title', __('Special day'))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/sweet-alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/datatable.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Batches') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Manager') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Batches') }}</span>
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
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('From') }}</th>
                                        <th>{{ __('To') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                        @if(isset($specialDays))
                                            @foreach($specialDays as $day)
                                                <tr>
                                                    <td>{{ $day->title }}</td>
                                                    <td>{{ $day->to }}</td>
                                                    <td>{{ $day->from }}</td>
                                                </tr>
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
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>
    <script src="{{ asset('bower_components/bootstrap-year-calendar/js/bootstrap-year-calendar.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/bootstrap-year-calendar/css/bootstrap-year-calendar.css') }}">
@endsection
