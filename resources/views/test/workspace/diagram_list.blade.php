@extends('admin.layout.master')

@section('title', __('diagram list'))

@section('module', __('Diagram List'))

@section('content')
<div class="m-content">
    <div class="row">
        @forelse($listDiagram as $item)
        <div class="col-lg-6">
            <div class="m-portlet m-portlet--primary m-portlet--head-solid-bg m-portlet--head-sm" m-portlet="true" id="m_portlet_tools_2">
                <div class="m-portlet__head">
                    <div class="m-portlet__head-caption">
                        <div class="m-portlet__head-title">
                            <span class="m-portlet__head-icon">
                                <i class="fa fa-warehouse"></i>
                            </span>
                            <h3 class="m-portlet__head-text">
                                <a href="{{ route('schedule.workplace.view', ['id' => $item->id]) }}" class="text-white">{{ $item->name }}</a>
                            </h3>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
                    <p>
                        {{ $item->name }}
                    </p>
                    <a href="{{ route('diagram_detail', $item->id) }}" title="{{ __('diagram detail') }}">
                        {!! Html::image($item->DesignDiagram, null) !!}
                    </a>
                </div>
            </div>
        </div>
        @empty
            @include('admin.components.alert', ['type' => 'warning', 'message' => __('Have no data!')])
        @endforelse
    </div>
</div>
@endsection
