<div>
    @if(Entrust::can('design-diagrams'))
        <div class="choose-column-row d-none">
            <div class="form-group row">
                {!! Form::label('row', __('Row'), ['class' => 'col-form-label col-md-1']) !!}
                <div class="col-md-2">
                    {!! Form::number('row', $workspace->seat_per_row, ['class' => 'form-control']) !!}
                </div>
                {!! Form::label('column', __('Column'), ['class' => 'col-form-label col-md-1']) !!}
                <div class="col-md-2">
                    {!! Form::number('column', $workspace->seat_per_column, ['class' => 'form-control']) !!}
                </div>
                <button class="generate btn btn-success">{{ __('Generate') }}</button>                 
            </div>
            <div class="cell-options">
                <button class="btn btn-success default-areas door">{{ __('Door') }}</button>
                <button class="btn btn-success default-areas path">{{ __('Path') }}</button>
                <button class="btn btn-success default-areas freespace">{{ __('Freespace') }}</button>
                <div class="form-group row mt-2">
                    {!! Form::label('name', __('Area Name'), ['class' => 'col-form-label']) !!}
                    <div class="col-md-3">
                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="custom-control custom-checkbox col-sm-2">
                        <div class="mt-3">
                            {!! Form::label('usable', __('Is Disable'), ['class' => 'control-label']) !!}
                            {!! Form::checkbox('usable', 1, 0) !!}
                        </div>
                    </div>
                    
                    {!! Form::label('color', __('Choose Color'), ['class' => 'col-form-label']) !!}
                    <div class="col-md-1">
                        {!! Form::input('color', 'color', null) !!}
                    </div>
                    <button class="btn btn-primary" id="newArea">{{ __('Create New Area') }}</button>
                </div>
            </div>

            <div class="mb-3">
                <button class="btn btn-success" id="saveDiagram">{{ __('Save') }}</button>
                <button class="btn btn-dark" id="cancel"> {{ __('Cancel') }}</button>
            </div>
        </div>
        <button class="btn btn-primary" id="edit_diagram_trigger">{{ __('Edit') }}</button>
    @endif
    <div class="area-section mt-2">
    </div>

    <div class="design-section overflow-scroll scroll-section">
        <table class="m-auto">
            <tbody>
                @for($i = 0; $i < $workspace->seat_per_row; $i++)
                    <tr class="row">
                        @for($j = 0; $j < $workspace->seat_per_column; $j++)
                            <td class="seat-cell area-selected" row="{{ $i }}" column="{{ $j }}"></td>
                        @endfor
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
    <div class="position-fixed overflow-x-scroll" id="scroll">
        <div class="scroll"></div>
    </div>
</div>

<script src="{{ asset('js/scrollbar.js') }}"></script>
