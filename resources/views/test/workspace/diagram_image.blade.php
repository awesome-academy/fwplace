<div class="col-lg-12 text-center">
    {!! Html::image($workspace->photo, null, ['usemap' => '#image-map']) !!}
</div>
@if($diagramDetail->diagramContent)
    {!! $diagramDetail->diagramContent !!}
@else
    <div class="text-center">
        <span class="text-danger">{{ __('This workspace don\'t have this kind of diagram') }}</span>
    </div>;
@endif

<script src="{{ asset('js/showName.js') }}"></script>
