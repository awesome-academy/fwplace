@extends('admin.layout.master')

@section('title', __('Work Schedule'))

@section('module', __('Number of Employees'))

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
                        <div id="loading" class="text-center">
                            {!! Html::image(asset(config('site.static') . 'loading.gif'), null) !!}
                        </div>
                        <div id="m_calendar" data-url="{{ route('schedule.get.data', ['id' => $location->id]) }}"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    {{ Html::script('js/calendar.js') }}
@endsection
