@extends('admin.layout.master')

@section('title', __('diagram list'))

@section('module', __('Diagram List'))

@section('content')
<div class="m-content">
    <div class="row">
        <div class="col-lg-12 text-center">
            {!! Html::image($diagramDetail->DesignDiagram, null, ['usemap' => '#image-map']) !!}
        </div>
        {!! $diagramDetail->content !!}
    </div>
</div>
@endsection
