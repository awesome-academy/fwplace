@extends('admin.layout.master')

@section('title', __('Workspace'))

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Workspace List') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Model Workspace') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Workspace List') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')
    <div class="m-portlet">
        <div class="m-portlet__body">
            <div class="m-section">
                <div class="m-section__content">
                    <table class="table m-table m-table--head-bg-success table-middle">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>@lang('Workspace')</th>
                            <th>@lang('Location')</th>
                            <th>@lang('Total Seat')</th>
                            @if (Entrust::can(['add-workspaces']))
                                <th>
                                    <a class="btn m-btn--pill m-btn--air btn-secondary" data-toggle="modal" data-target="#m_modal_4" data-toggle="m-tooltip" data-placement="left" data-original-title="@lang('Add Workspace')">
                                        <i class="flaticon-add"></i>
                                    </a>
                                </th>
                            @else
                                <th>{{ __('Action') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>

                        @php
                            $programIndex = 1;
                        @endphp

                        @forelse($workspaces as $key => $item)
                            <tr>
                                <th scope="row">{{ ($key+1) }}</th>
                                <td class="sorting_1" tabindex="0">
                                    <div>
                                        <div class="m-card-user__details">
                                            <h3 class="m-card-user__name">
                                                <a href="{{ route('detail_workspace', $item->id) }}">{{ $item->name }}</a>
                                            </h3>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @foreach($item->locations as $location)
                                        <p>{{ $location->name }} : {{ $location->total_seat }} @lang('seat')</p>
                                    @endforeach
                                </td>
                                <td>
                                    <h5>{{ $item->total_seat }}</h5>
                                </td>
                                <td>
                                    @if (Auth::user()->program_id == $programIndex)
                                        <a class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" href="{{ route('generate', ['id' => $item->id]) }}" data-toggle="m-tooltip" data-placement="left" data-original-title="@lang('Edit Workspace')">
                                            <i class="flaticon-edit-1"></i>
                                        </a>                                
                                    @endif

                                    @php
                                        $programIndex++;
                                    @endphp

                                    @if (Entrust::can(['delete-workspaces']))
                                        {!! Form::open(['route' => ['workspaces.destroy', $item->id],
                                            'class' => 'd-inline',
                                            'method' => 'DELETE'
                                        ]) !!}
                                        {!! Form::button('<i class="flaticon-cancel"></i>', [
                                            'class' => 'delete btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill',
                                            'type' => 'submit',
                                            'message' => __('Delete this item?')
                                        ]) !!}
                                        {!! Form::close() !!}
                                    @endif
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
    <div class="modal fade" id="m_modal_4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-lg-12">
                        <div class="m-portlet m-portlet--tab">
                            {!! Form::open(['url' => route('test.save'), 'files' => true, 'method' => 'POST']) !!}
                                <div class="m-portlet__body">
                                    <div class="form-group m-form__group m--margin-top-10">
                                        <div class="alert m-alert m-alert--default text-center" role="alert">
                                           {{ __('Registered Workspace Form') }}
                                        </div>
                                    </div>
                                    <p id="list-seat"></p>
                                    <div class="m-portlet__body">
                                        <div class="form-group m-form__group">
                                            {!! Form::label(__('Name')) !!}
                                            {!! Form::text('name', request('name'), ['class' => 'form-control m-input m-input--air m-input--pill', 'placeholder' => __('Name')]) !!}
                                        </div>
                                          <div class="form-group m-form__group">
                                            {!! Form::label(__('total_seat')) !!}
                                            {!! Form::number('total_seat', request('total_seat'), ['class' => 'form-control m-input m-input--air m-input--pill', 'placeholder' => __('total_seat')]) !!}
                                        </div>
                                         <div class="form-group m-form__group">
                                            {!! Form::label(__('Workspace')) !!}
                                            {!! Form::number('seat_per_row', request('seat_per_row'), ['class' => 'form-control m-input m-input--air m-input--pill', 'placeholder' => __('seat_per_row')]) !!}
                                        </div>
                                        <div class="form-group m-form__group row">
                                            {!! Form::label(__('Image Office')) !!}
                                            <div class="custom-file">
                                                {!! Form::file('image', ['class' => 'custom-file-input', 'id' => 'input-display']) !!}
                                                {!! Form::label(__('Choose file'), null, ['class' => 'custom-file-label']) !!}
                                                {!! $errors->first('image', '<p class="text-danger">:message</p>') !!}
                                            </div>
                                            <img src="" alt="" id="image-display">
                                        </div>
                                    </div>
                                    <div class="m-portlet__foot m-portlet__foot--fit">
                                        <div class="m-form__actions" id="save-create-location">
                                            {!! Form::submit(__('Save'), ['class' => 'btn btn-success']) !!}
                                        </div>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
