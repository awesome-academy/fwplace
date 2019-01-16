@extends('admin.layout.master')

@section('title', __('Add Workspace'))

@section('css')
    {{ Html::style(asset('css/addlocation.css')) }}
@endsection

@section('content')
<div class="m-portlet pl-5 py-5">
    @if(Entrust::can(['add-location']))
        <div class="location">
            <div class="form-horizontal col-md-9">
                {!! Form::label('row', __('Row'), ['class' => 'col-form-label']) !!}
                
                <div class="form-group d-inline-block">
                    {!! Form::number('row', $location->seat_per_row, ['class' => 'form-control ml-2', 'min' => 0]) !!}
                </div>
                {!! Form::label('column', __('Column'), ['class' => 'col-form-label ml-5']) !!}
            
                <div class="form-group d-inline-block">
                    {!! Form::number('column', $location->seat_per_column, ['class' => 'form-control ml-2', 'min' => 0]) !!}
                </div>
                {!! Form::submit(__('Save'), ['class' => 'btn btn-success ml-5', 'id' => 'submit']) !!}
                <div>
                    @if($errors->any())
                        <span class="text-danger">{{ __($errors->first()) }}</span>
                    @endif
                </div>
            </div>
        </div>
    @endif
    <div class="workspace">
        <div class="all_seat">
            <table>
                @if (count($renderSeat) > 0 && Entrust::can('add-location'))
                    <div class="mb-2">
                        <button class="btn btn-primary btn-seat" id="disable-seat">{{ __('Disable Seat') }}</button>
                        <button class="btn btn-primary btn-seat" id="enable-seat">{{ __('Enable Seat') }}</button>
                        <button class="btn btn-primary btn-seat" id="clear-seat">{{ __('Clear Seat') }}</button>
                        <button class="btn btn-danger" id="cancel">{{ __('Cancel') }}</button>
                    </div>
                @endif

                @forelse($renderSeat as $row)
                    <tr class="row">
                        @foreach($row as $key => $value)
                        <td>
                            <div seat_id="" avatar="" program="" position="" user_id="" class="seat {{ $value === config('site.disable_seat') ? 'disabled' : '' }}" id="{{ $key }}">
                                <p class="seat-name">{{ $key }}</p>
                            </div>
                        </td>
                        @endforeach
                    </tr>
                @empty
                    <div class="row">
                        <div class="text-center">
                            <span>{{ __('This location don\'t have any seat') }}</span>
                        </div>
                    </div>
                @endforelse
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="m-portlet">
                <div class="m-portlet__body">
                    <div class="m-section">
                        <div class="m-section__content">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Day'), ['class' => 'col-form-label col-lg-3']) !!}
                                            </div>
                                        </th>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Day of Week'), ['class' => 'col-form-label col-lg-8']) !!}
                                            </div>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Morning'), ['class' => 'col-form-label col-md-6 text-center']) !!}
                                            </div>
                                        </th>
                                        <th>
                                            <div class="form-group m-form__group row">
                                                {!! Form::label('label', __('Afternoon'), ['class' => 'col-form-label col-lg-6 text-center']) !!}
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                {!! Form::open(['url' => route('seats.store'), 'method' => 'post' , 'id' => 'add_form' ]) !!}
                                <tbody>
                                    @forelse($dates as $day)
                                        <tr>
                                            <th scope="row" class="work-day">{{ $day->date }}</th>
                                            <td>{{ $day->weekDay }}</td>
                                            @if($day->shift !== config('site.shift.off'))
                                            <td>
                                                @if($day->shift === config('site.shift.morning') || $day->shift === config('site.shift.all'))
                                                    {!! Form::select('morning[' . $day->id . ']', $day->morningSeats, $day->seats && count($day->seats) > 0 ? $day->seats[0]->id : null, [
                                                            'class' => 'form-control morning',
                                                            'data-date' => $day->date,
                                                            'data-shift' => config('site.shift.morning'),
                                                        ]) !!}
                                                @endif
                                            </td>
                                            <td>
                                                @if($day->shift === config('site.shift.afternoon') || $day->shift === config('site.shift.all'))
                                                    {!! Form::select('afternoon[' . $day->id . ']', $day->afternoonSeats, $day->seats && count($day->seats) > 1 ? $day->seats[1]->id : null, [
                                                            'class' => 'form-control afternoon',
                                                            'data-date' => $day->date,
                                                            'data-shift' => config('site.shift.afternoon'),
                                                        ]) !!}
                                                @endif
                                            </td>
                                            @else
                                                <td colspan="2" class="bg-danger-light text-center text-dark">{{ __('Dayoff') }}</td>
                                            @endif
                                        </tr>
                                        @if(Carbon\Carbon::parse($day->date)->format('l') === config('site.last_work_day_of_week'))
                                            <tr>
                                                <th class="bg-secondary"></th>
                                                <td colspan="3" class="bg-secondary"></td>
                                            </tr>
                                        @endif
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-danger">{{ __('You don\'t have work schedule in this location') }}</td>
                                        </tr>        
                                    @endforelse
                                </tbody>
                            </table>
                            <div class="m-form m-form--fit m-form--label-align-right">
                                {!! Form::submit(__('Save') . '!', ['class' => 'btn m-btn--pill    btn-primary btn-lg m-btn m-btn--custom']) !!}
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>                            
</div>
@endsection

@section('js')
    {{ Html::script(asset('js/jquery-ui.js')) }}
    {{ Html::script(asset('js/config.js')) }}
    <script src="{{ asset('js/register_seat.js') }}"></script>
    @if(Entrust::can('add-location'))
        <script src="{{ asset('js/edit_seat.js') }}"></script>
    @endif
@endsection
