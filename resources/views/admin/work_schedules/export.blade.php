<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>
    @include('admin.assets.css')
</head>
<body>
    <h3 class="text-center font-weight-bold">{{ __('Work Schedule Of Month ') . Date('m') . '-' . Date('Y') }}</h3>
    <tr></tr>
    <tr></tr>
    <tr>
        <th>{{ __('Workspace') }}</th>
        <td>{{ $workspace }}</td>
    </tr>
    <tr>
        <th>{{ __('Position') }}</th>
        <td>{{ $position }}</td>
    </tr>
    <tr>
        <th>{{ __('Program') }}</th>
        <td>{{ $program }}</td>
    </tr>
    @if(count($users) > 0)
        <table>
            <thead>
                <tr class="left-row">
                    <th class="text-center">{{ __('Num.') }}</th>
                    <th class="text-center">{{ __('Fullname') }}</th>
                    <th class="text-center col-min-3">{{ __('Position') }}</th>
                    <th class="text-center col-min-2">{{ __('University') }}</th>
                    <th class="text-center col-min-3">{{ __('Office') }}</th>
                    @for($i = 1; $i <= Date('t'); $i++)
                        <th class="col-md-1 text-center">{{ $i }}</th>
                    @endfor
                    <th class="text-center col-md-1">W</th>
                    <th class="text-center col-md-1">M</th>
                    <th class="text-center col-md-1">A</th>
                    <th class="text-center col-md-1">X</th>
                    <th class="text-center col-min-2">{{ __('Work Days') }}</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $num = 1;
                @endphp
                @foreach ($users as $user)
                    <tr class="left-row">
                        <td class="text-center">{{ $num++ }}</td>
                        <td class="word-break-all">{{ $user->name }}</td>
                        @php
                            $count = [];
                            for($i = 0; $i < 4; $i++) {
                                $count[$i] = 0;
                            }
                        @endphp
                        <td class="word-break-all">{{ $user->position->name . ' ' . $user->program->name }}</td>
                        <td class="word-break-all">{{ $user->school }}</td>
                        <td class="word-break-all">{{ $user->workspace->name }}</td>
                        @for($i = 1; $i <= Date('t'); $i++)
                            @php
                                $date = $i . '-' . Date('m') . '-' . Date('Y');
                            @endphp
                            @if(isset($user->schedules[$i]))
                                <td style="{{ (Date('N', strtotime($date)) >= 6) ? 'background-color: #f4516c' : '' }}">{{ config('api.status.short.' . $user->schedules[$i]->shift) }}</td>
                                @php($count[$user->schedules[$i]->shift]++)
                            @else
                                <td style="{{ (Date('N', strtotime($date)) >= 6) ? 'background-color: #f4516c' : '' }}"></td>
                            @endif
                        @endfor
                        <td class="text-center">{{ $count[1] }}</td>
                        <td class="text-center">{{ $count[2] }}</td>
                        <td class="text-center">{{ $count[3] }}</td>
                        <td class="text-center">{{ $count[0] }}</td>
                        <td class="text-center">{{ $count[1] + ($count[2] + $count[3]) * 0.5 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    <div class="mt-3">
        <table class="col-md-2">
            @for($i = 0; $i < 4; $i++)
                <tr>
                    <td>{{ __(config('api.status.' . $i)) }}</td>
                    <td>{{ config('api.status.short.' . $i) }}</td>
                </tr>
            @endfor
        </table>
    </div>
    @else
        <div>
            <h4 class="text-center p-5">{{ __('No Data') }}</h4>
        </div>
    @endif
</body>
</html>
