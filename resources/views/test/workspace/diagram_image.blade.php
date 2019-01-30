@if($diagramDetail->diagramContent)
    {!! $diagramDetail->diagramContent !!}
@else
    <div class="text-center">
        <span class="text-danger">{{ __('This workspace don\'t have this kind of diagram') }}</span>
    </div>
@endif
<div class="col-lg-12 text-center">
    <div class="position-relative">
        {!! Html::image($workspace->photo, null, ['usemap' => '#image-map', 'id' => 'workspace_img']) !!}
    </div>
</div>

<script src="{{ asset('js/showName.js') }}"></script>
