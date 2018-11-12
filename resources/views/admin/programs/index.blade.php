@extends('admin.layout.master')
@section('title', __('Programs') )
@section('module', __('Programs'))
@section('content')
    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet">
                <div class="m-section">
                    <div class="m-section__content">
                        <table class="table m-table m-table--head-bg-success">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('Name Program') }}</th>

                                    @if (Entrust::can(['add-programs']))
                                        <th>
                                            <a href="{{ route('programs.create') }}" class="btn m-btn--pill m-btn--air btn-secondary table-middle " data-toggle="m-tooltip" data-placement="left" data-original-title="{{ __('Add New') }}">
                                                <i class="flaticon-add"></i>
                                            </a>
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>

                                @foreach($dataPrograms as $key => $pro)

                                    <tr>
                                        <th scope="row">{{ $key + 1 }}</th>

                                        <td>{{ $pro->name }}</td>

                                        <td>
                                            @if (Entrust::can(['edit-programs']))
                                                <a href="{{ route('programs.edit', ['id' => $pro->id]) }}" class="btn btn-warning m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill" data-skin="dark" data-toggle="m-tooltip" data-placement="left" data-original-title="{{ __('Edit') }}">
                                                    <i class="flaticon-edit-1"></i>
                                                </a>
                                            @endif

                                            @if (Entrust::can(['delete-programs']))
                                                {!! Form::open(['route' => ['programs.destroy', $pro->id], 'method' => 'DELETE', 'class' => 'd-inline']) !!}
                                                {!! Form::button('<i class="flaticon-cancel"></i>', ['class' => 'btn btn-danger m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill delete', 'data-toggle' => 'm-tooltip', 'data-placement' => 'right','data-skin' => 'dark', 'data-original-title' => __('Delete'), 'type' => 'submit' ]) !!}
                                                {!! Form::close() !!}
                                            @endif
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
