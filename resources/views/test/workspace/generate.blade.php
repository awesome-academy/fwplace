@extends('admin.layout.master')

@section('title', __('Add Workspace'))

@section('css')
    {{ Html::style(asset('css/addlocation.css')) }}
@endsection

@section('content')
<div class="m-portlet pl-5 py-5">
    <div class="workspace">
        <div class="all_seat">
            <table >
                
                @forelse($renderSeat as $row)
                    <tr class="row">
                        @foreach($row as $seat)
                        <td>
                            <div seat_id="" avatar="" program="" position="" user_id="" class="seat {{ $seat === null ? 'disabled' : '' }}" id="{{ $seat }}">
                                <p class="seat-name">{{ $seat ?? 'X' }}</p>
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
                                    @foreach($dates as $day)
                                        <tr>
                                            <th scope="row" class="work-day">{{ $day->date }}</th>
                                            <td>{{ $day->weekDay }}</td>
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
                                        </tr>
                                        @if(Carbon\Carbon::parse($day->date)->format('l') === config('site.last_work_day_of_week'))
                                            <tr>
                                                <th class="bg-secondary"></th>
                                                <td colspan="3" class="bg-secondary"></td>
                                            </tr>
                                        @endif
                                    @endforeach
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
@endsection
