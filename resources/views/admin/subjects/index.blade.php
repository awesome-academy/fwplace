@extends('admin.layout.master')

@section('title', __('Subject Manager'))

@section('content')
    <div id="app">
        <subject></subject>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
@endsection
