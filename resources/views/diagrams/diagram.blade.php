@extends('admin.layout.master')

@section('title', __('Show Diagram'))

@section('module')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Show Diagram') }}</h3>
        <h3 class="m-subheader__title">{{ $workspace->name }}</h3>
    </div>
@endsection

@section('content')
<div id="diagram-img">
    <div class="col-lg-12 text-center">
        {!! Html::image($workspace->photo, null, ['usemap' => '#image-map']) !!}
    </div>
    @if($diagram->diagramContent)
        {!! $diagram->diagramContent !!}
    @else
        <div class="text-center">
            <span class="text-danger">{{ __('This workspace don\'t have this kind of diagram') }}</span>
        </div>;
    @endif
</div>
@endsection

@section('js')
    <script src="{{ asset('js/showName.js') }}"></script>
@endsection
