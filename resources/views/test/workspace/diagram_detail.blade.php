@extends('admin.layout.master')

@section('title', __('diagram list'))

@section('module', __('Diagram List'))

@section('content')
<div class="m-content">
    <div class="row">
        @if(isset($diagramDetail) && $diagramDetail->diagramContent)
            {!! $diagramDetail->diagramContent !!}
        @else
            <div class="text-center">
                <span class="text-danger">{{ __('This workspace don\'t have this kind of diagram') }}</span>
            </div>
        @endif
        <div class="col-lg-12 text-center">
            {!! Html::image($diagramDetail->DesignDiagram, null, ['usemap' => '#image-map']) !!}
        </div>
    </div>
</div>
@endsection
