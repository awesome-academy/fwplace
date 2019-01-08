@extends('admin.layout.master')

@section('title', __('Show Diagram'))

@section('module')
    <div class="mr-auto">
        <h3 class="m-subheader__title m-subheader__title--separator">{{ __('Show Diagram') }}</h3>
        <h3 class="m-subheader__title">{{ $workspace->name }}</h3>
    </div>
@endsection

@section('content')
<div class="design without-diagram">
    <div class="area-section mt-2">
    </div>

    <div class="design-section d-flex justify-content-center">
        <table>
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
</div>

{!! Form::hidden('workspace_id', $workspace->id, ['id' => 'workspace_id']) !!}

@endsection

@section('js')
    <script src="{{ asset('js/showDiagram.js') }}"></script>
@endsection
