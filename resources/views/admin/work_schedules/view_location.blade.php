@extends('admin.layout.master')

@section('title', __('Locations'))

@section('module', __('Workspace') . ' : ' . $workspace->name)

@section('content')
    <div class="m-content">
        <div class="row">
            @forelse ($locationList as $location)
                <div class="col-lg-6">
                    <div class="m-portlet m-portlet--success m-portlet--head-solid-bg m-portlet--head-sm"
                         m-portlet="true" id="m_portlet_tools_2">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
                                    <span class="m-portlet__head-icon">
                                        <i class="fa fa-warehouse"></i>
                                    </span>
                                    <h3 class="m-portlet__head-text">
                                        <a href="{{ route('schedule.by.location', ['id' => $location->id]) }}" class="text-white">
                                            {{ $location->name }}
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            {!! Html::decode(link_to_route('locations.edit','<i class="flaticon-edit-1" aria-hidden="true"></i>', ['id' => $location->id], ['class' => 'mt-2 btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill edit_location'])) !!}

                        </div>
                        <div class="m-portlet__body">
                            <p>
                                <b>
                                    @lang('Total Seat:', ['total' => $location->seats()->count()])
                                </b>
                            </p>
                            {!! Html::image($location->photo, null, ['class' => 'w-100 workspace_image']) !!}
                        </div>
                    </div>
                </div>
            @empty
                @include('admin.components.alert', ['type' => 'warning', 'message' => __('Have no data!')])
            @endforelse
        </div>
    </div>
@endsection
