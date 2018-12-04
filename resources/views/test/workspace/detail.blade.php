@extends('admin.layout.master')
@section('title', __('Detail Workspace'))
@section('module')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Detail Workspace') }}</h3>
    </div>
@endsection
@section('content')
    <div class="m-portlet pl-5 py-5">
        <div class="workspace">
            <input type="hidden" value="{!! $colorLocation !!}" id="colorLocation">
            <div id="noteLocation">
                <p>{{ __('Note:') }}</p>
            </div>
            <div class="all_seat">
                @foreach($renderSeat as $row)
                    <div class="row">
                        @foreach($row as $seat)
                            <div class="seat @if ($seat === null) disabled @endif" id="{{ $seat }}">
                                {{ $seat ?? 'X'}}
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/jquery-ui.js') }}"></script>
    <script src="{{ asset('js/detailworkspace.js') }}"></script>
@endsection
