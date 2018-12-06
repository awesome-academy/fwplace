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
                    <div class="text-right">
                        {!! Html::decode(Form::label('locations.edit', '<i class="flaticon-edit-1" aria-hidden="true"></i>', ['class' => 'mt-2 btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill edit_location', "data-toggle" => "modal", "data-target" => "eidt_diagram_modal" . $item->id])) !!}
                    </div>
                    <div class="modal fade" id="eidt_diagram_modal{{ $item->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Edit Diagram') }}</h5>
                                    {!! Form::button('<span aria-hidden="true">&times;</span>', ['type' => 'button', 'class' => 'close', 'data-dismiss' => 'modal', 'aria-label' => 'Close']) !!}
                                </div>

                                <div class="modal-body">
                                    {!! Form::open(['method' => 'POST', 'id' => 'edit_diagram_form', 'name' => 'edit_diagram_form']) !!}

                                        <div class="form-group">
                                            {!! Form::label(__('Name Diagram'), null, ['for' => 'recipient-name', 'class' => 'form-control-label']) !!}
                                            {!! Form::text('name', $item->name, ['class' => 'form-control', 'id' => 'name']) !!}
                                        </div>

                                    {!! Form::close() !!}
                                </div>

                                <div class="modal-footer">
                                    {!! Form::button(__('Close'), ['type' => 'button', 'class' => 'btn btn-secondary', 'data-dismiss' => 'modal']) !!}
                                    {!! Form::button(__('Create'), ['type' => 'submit', 'class' => 'btn btn-primary', 'id' => 'add_program_btn']) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="m-portlet__body">
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
