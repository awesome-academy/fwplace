@extends('admin.layout.master')

@section('title', __('Workspace'))

@section('css')
    <script src="{{ asset('js/show_modal.js') }}"></script>
@endsection

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
                                <th class="text-center">@lang('Workspace')</th>
                                <th class="thumbnail text-center">@lang('Thumbnail')</th>
                                <th class="text-center">@lang('Location')</th>
                                <th class="text-center">@lang('Total Seat')</th>
                                @if (Entrust::can(['add-workspaces']))
                                    <th class="text-center">
                                        <a class="btn m-btn--pill m-btn--air btn-secondary" id="add-workspace" data-toggle="modal" data-target="#m_modal_4" data-toggle="m-tooltip" data-placement="left" data-original-title="@lang('Add Workspace')">
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
                                                    <a href="{{ route('image_map', ['id' => $item->id]) }}">{{ $item->name }}</a>
                                                </h3>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <img src="{{ $item->photo }}" alt="">
                                    </td>
                                    @php
                                        $total_seat = 0;
                                    @endphp
                                    <td class="p-0">
                                        <table class="w-100 b-table">
                                            @foreach($item->locations as $location)
                                                @if($location->usable == config('site.default.usable'))
                                                    <tr>
                                                        <td class="w-50">
                                                            <a href="{{ route('generate', ['id' => $location->id]) }}">{{ $location->name }} : {{ $location->total_seat ?? 0 }} {{ (($location->total_seat ?? 0) > 1 ) ? __('seats') : __('seat') }}</a>
                                                        </td>
                                                        <td>
                                                            <a href="{{ route('schedule.by.location', ['id' => $location->id]) }}" class="btn btn-primary">{{ __('Schedule') }}</a>
                                                        </td>
                                                        @php
                                                            $total_seat += $location->total_seat;
                                                        @endphp
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </table>
                                    </td>
                                    <td>
                                        <h5>{{ $total_seat }}</h5>
                                    </td>
                                    <td class="text-center">
                                        @if (Entrust::hasRole('admin'))
                                            <a href="{{ route('image_map', ['id' => $item->id]) }}"
                                                class="btn btn-primary m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill"
                                                data-toggle="m-tooltip"
                                                data-original-title="{{ __('Design Diagram') }}"
                                            >
                                                <i class="flaticon-edit"></i>
                                            </a>
                                            
                                            <a class="edit-workspace btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" 
                                                data-toggle="modal" 
                                                data-target="#m_modal_4"
                                                onclick="showModal({{ $item->id }}, '{{ $item->name }}', '{{ $item->photo }}')"
                                            >
                                                <i class="flaticon-edit-1"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('show_diagram', ['id' => $item->id]) }}"
                                                class="btn btn-primary m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill"
                                                data-toggle="m-tooltip"
                                                data-original-title="{{ __('Show Diagram') }}"
                                            >
                                                <i class="flaticon-edit"></i>
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
                            {!! Form::open(['url' => route('workspaces.store'), 'files' => true, 'method' => 'POST']) !!}
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
                                            {!! Form::text('name', request('name'), [
                                                'id' => 'workspace-name',
                                                'class' => 'form-control m-input m-input--air m-input--pill',
                                                'placeholder' => __('Name')
                                            ]) !!}
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
                                {!! Form::hidden('id', '', ['id' => 'workspace-id']) !!}
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('js/edit_workspace.js') }}"></script>
@endsection
