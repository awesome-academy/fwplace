@extends('admin.layout.master')

@section('title', __('Role'))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/role-user.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Role') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Employee') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a href="{{ route('users.index') }}" class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Employee List') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Role') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')

    <div class="m-portlet m-portlet--mobile">
        <div class="m-portlet__body">
            <table class="table table-striped- table-bordered table-hover table-checkable" id="roles_table">
                <thead>
                    <tr>
                        <th class="text-center">{{ __('#') }}</th>
                        <th class="text-center">{{ __('Role') }}</th>
                        <th class="text-center">{{ __('Description') }}</th>
                        <th class="text-center">{{ __('Permission') }}</th>
                        <th class="text-center">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody>

                    @if (!empty($roles))
                        @foreach ($roles as $key => $role)

                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $role->display_name }}</td>
                                <td class="text-center">{{ $role->description }}</td>
                                <td class="td-permission">
                                    @if (!empty($role->permissions))
                                        @foreach ($role->permissions as $permission)
                                            <span class="m-badge m-badge--success m-badge--wide span-permission">
                                                {{ $permission->display_name }}
                                            </span>
                                        @endforeach
                                    @endif
                                </td>
                                <td class="text-center font-size-18">
                                    <input type="hidden" id="checked-{{ $role->id }}" value="{{ $role->checked }}">

                                    @if ($role->checked == 1)
                                        <i id="action-{{ $role->id }}" class="fa fa-check-circle update-role" data-userid="{{ $user->id }}" data-roleid="{{ $role->id }}" aria-hidden="true"></i>
                                    @else 
                                        <i id="action-{{ $role->id }}" class="fa fa-circle-notch update-role" data-userid="{{ $user->id }}" data-roleid="{{ $role->id }}" aria-hidden="true"></i>
                                    @endif
                                </td>
                            </tr>

                        @endforeach
                    @endif

                </tbody>
            </table>
        </div>
    </div>

    {!! Form::hidden('add_success_lang', __('Add success'), ['id' => 'add_success_lang']) !!}
    {!! Form::hidden('delete_success_lang', __('Delete success'), ['id' => 'delete_success_lang']) !!}

@endsection

@section('js')
    <script src="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('bower_components/metro-asset/demo/default/custom/crud/datatables/data-sources/html.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/toastr.min.js') }}"></script>

    @routes
    <script src="{{ mix('js/role-user.js') }}"></script>
@endsection
