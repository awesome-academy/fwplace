@extends('admin.layout.master')

@section('title', __('Position'))

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Position') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Position') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet m-portlet--tab">
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table m-table m-table--head-bg-success">
                                <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Position') }}</th>
                                        <th>{{ __('Type') }}</th>

                                        @if (Entrust::can(['add-positions']))
                                            <th>
                                                <a href="{{ route('positions.create') }}" class="btn m-btn--pill m-btn--air btn-secondary table-middle " data-toggle="m-tooltip" data-placement="left" data-original-title="{{ __('Add new') }}">
                                                    <i class="flaticon-add"></i>
                                                </a>
                                            </th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @if (isset($positions))
                                        @foreach ($positions as $key => $position)
                                        
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>

                                                <td>{{ $position->name }}</td>

                                                @if ($position->is_fulltime == 0)
                                                    <td>{{ __('Parttime') }}</td>
                                                @else
                                                    <td>{{ __('Fulltime') }}</td>
                                                @endif

                                                <td>
                                                    @if (Entrust::can(['edit-positions']))
                                                        <a href="{{ route('positions.edit', $position->id) }}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" data-toggle="m-tooltip" data-placement="left" data-original-title="{{ __('Edit') }}">
                                                            <i class="flaticon-edit-1"></i>
                                                        </a>
                                                    @endif

                                                    @if (Entrust::can(['delete-positions']))
                                                        {!! Form::open(['route' => ['positions.destroy', $position->id], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                                        {!! Form::button('<i class="flaticon-cancel"></i>', ['type' => 'submit', 'class' => 'btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill delete', 'data-toggle' => 'm-tooltip', 'data-placement' => 'right', 'data-original-title' => __('Delete')]) !!}
                                                        {!! Form::close() !!}
                                                    @endif
                                                </td>
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
