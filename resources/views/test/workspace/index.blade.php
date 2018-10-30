@extends('admin.layout.master')
@section('title', __('Workspace'))
@section('module')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Employee') }}</h3>
    </div>
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
                            <th>@lang('Total Seat')</th>
                            @if (Auth::user()->role == config('site.permission.admin'))
                                <th>
                                    <a href="{{ route('create_workspace') }}" class="btn m-btn--pill m-btn--air btn-secondary" data-toggle="m-tooltip" data-placement="left" data-original-title="@lang('Add Workspace')">
                                        <i class="flaticon-add"></i>
                                    </a>
                                </th>
                                <th>@lang('Add Location')</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
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
                                    <h5>{{ $item->total_seat }}</h5>
                                </td>
                                @if (Auth::user()->role == config('site.permission.admin'))
                                    <td>
                                        <a href="{{ route('workspaces.edit', ['id' => $item->id]) }}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" data-toggle="m-tooltip" data-placement="left" data-original-title="@lang('Edit Workspace')">
                                            <i class="flaticon-edit-1"></i>
                                        </a>
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
                                    </td>
                                    <td>
                                        <a href="{{ route('generate', ['id' => $item->id]) }}">
                                            <i class="flaticon-add"></i>
                                        </a>
                                    </td>
                                @endif
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
@endsection
