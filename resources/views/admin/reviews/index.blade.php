@extends('admin.layout.master')

@section('title', 'Reviews')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ mix('css/master.css') }}">
@endsection

@section('content')
    <div id="app">
        <review></review>
    </div>
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/review.js') }}"></script>
@endsection

