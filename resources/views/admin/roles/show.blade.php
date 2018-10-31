@extends('admin.layout.master')

@section('title', __('Permission'))

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('bower_components/lib_fwplace/css/sweet-alert.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ mix('css/datatable.css') }}">
@endsection

@section('module')

    <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Permission') }}</h3>

    <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
        <li class="m-nav__item m-nav__item--home">
            <a href="{{ route('admin.index') }}" class="m-nav__link m-nav__link--icon">
                <i class="m-nav__link-icon la la-home"></i>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('System Management') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a href="{{ route('roles.index') }}" class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Role') }}</span>
            </a>
        </li>
        <li class="m-nav__separator">-</li>
        <li class="m-nav__item">
            <a class="m-nav__link">
                <span class="m-nav__link-text">{{ __('Permission') }}</span>
            </a>
        </li>
    </ul>

@endsection

@section('content')

	<div class="m-portlet m-portlet--mobile">
        {!! Form::hidden('role_id', $role_id, ['id' => 'role_id']) !!}

        <div class="m-portlet__body">
            <table class="table table-striped- table-hover table-checkable" id="permission_role_table">
                <thead>
                    <tr>
                        <th>{{ __('#') }}</th>
                        <th>{{ __('Permission') }}</th>
                        <th>{{ __('Description') }}</th>
                        <th>{{ __('Created at') }}</th>
                        <th>{{ __('Action') }}</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    {!! Form::hidden('processing_lang', __('Processing'), ['id' => 'processing_lang']) !!}
    {!! Form::hidden('add_success_lang', __('Add success'), ['id' => 'add_success_lang']) !!}
    {!! Form::hidden('delete_success_lang', __('Delete success'), ['id' => 'delete_success_lang']) !!}
    {!! Form::hidden('add_lang', __('Add'), ['id' => 'add_lang']) !!}
    {!! Form::hidden('delete_lang', __('Delete'), ['id' => 'delete_lang']) !!}

@endsection

@section('js')
    <script src="{{ asset('bower_components/metro-asset/vendors/custom/datatables/datatables.bundle.js') }}"></script>
    <script src="{{ asset('bower_components/metro-asset/demo/default/custom/crud/datatables/data-sources/html.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/toastr.min.js') }}"></script>
    <script src="{{ asset('bower_components/lib_fwplace/js/sweet-alert.min.js') }}"></script>
    
    <script>
        /*Lang-i18n*/
        var processing_lang = $('#processing_lang').val();
        var add_success_lang = $('#add_success_lang').val();
        var delete_success_lang = $('#delete_success_lang').val();
        var add_lang = $('#add_lang').val();
        var delete_lang = $('#delete_lang').val();
        /*---------*/

        /*DataTable*/
        var role_id = $('#role_id').val();

        var table = $('#permission_role_table').DataTable({
            processing: true,
            language: {
                processing: "<div id='loader'>" + processing_lang + "</div>"
            },
            serverSide: true,
            ajax: '{{ route('roles.get_permission_role', [$role_id]) }}',
            columns: [
                {data: 'DT_Row_Index', name: 'id'},
                {data: 'display_name', name: 'display_name'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {
                    data: 'action',
                    name: 'action',
                    render: function (data) {
                        if (data.flag == 1) {
                            $string = '<input type="hidden" id="checked-' + data.permissionId + '" value="1">';

                            $string = $string + '<i id="action-' + data.permissionId + '"\
                                                    class="fa fa-check-circle"\
                                                    data-tooltip="tooltip"\
                                                    title="' + delete_lang + '"\
                                                    onclick="updatePermission(' + data.roleId + ', ' + data.permissionId + ')"\
                                                    aria-hidden="true"\
                                                    style="cursor: pointer; color: #3598dc; font-size: 20px;">\
                                                </i>';
                        } else {
                            $string = '<input type="hidden" id="checked-' + data.permissionId + '" value="0">';

                            $string = $string + '<i id="action-' + data.permissionId + '"\
                                                    class="fa fa-circle-notch"\
                                                    data-tooltip="tooltip"\
                                                    title="' + add_lang + '"\
                                                    onclick="updatePermission(' + data.roleId + ', ' + data.permissionId + ')"\
                                                    aria-hidden="true"\
                                                    style="cursor: pointer; color: #3598dc; font-size: 20px;">\
                                                </i>';
                        }

                        return $string;
                    }
                }
            ]
        });
        /*----------*/

        /*Thêm - Xóa quyền hạn*/
        function updatePermission(role_id, permission_id) {
            var checked = $('#checked-' + permission_id).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '{{ route('roles.update_permission_role') }}',
                data: {
                    checked: checked,
                    role_id: role_id,
                    permission_id: permission_id,
                },
                success: function(res)
                {
                    if (res.message == 'deleted') {
                        $('#action-' + permission_id).removeClass('fa fa-check-circle').addClass('fa fa-circle-notch');
                        $('#checked-' + permission_id).val(0);
                        toastr.success(delete_success_lang);
                    } 

                    if (res.message == 'added') {
                        $('#action-' + permission_id).removeClass('fa fa-circle-notch').addClass('fa fa-check-circle');
                        $('#checked-' + permission_id).val(1);
                        toastr.success(add_success_lang);
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    // 
                }
            });
        }
        /*--------------------*/
    </script>
@endsection
