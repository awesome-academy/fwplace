<?php

namespace App\Http\Controllers;

use App\Models\Seat;
use App\Models\User;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Repositories\SeatRepository;
use App\Http\Resources\WorkScheduleSeatResource;
use Carbon\Carbon;

class SeatController extends Controller
{
    private $seatRepository;

    public function __construct(SeatRepository $seatRepository)
    {
        $this->seatRepository = $seatRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->seatRepository->registerSeats($request->all());
    }

    public function collectUsers($users)
    {
        $result = collect();
        foreach ($users as $user) {
            $mergeUser = new \stdClass();
            $mergeUser->id = $user->id;
            $mergeUser->name = $user->name;
            $mergeUser->avatar =  $user->avatar ?
                                    Storage::url(config('site.user.image') . $user->avatar) :
                                    config('site.default-image');

            $schedule = new \stdClass();
            $schedule->date = Carbon::parse($user->date)->format('d-m-Y');
            $schedule->shift = $user->shift;

            $seat = new \stdClass();
            if (!isset($result[$user->seat_id])) {
                $seat->id = $user->seat_id;
                $seat->name = $user->seat_name;
                $mergeUser->schedules = collect();
                $mergeUser->schedules->put($schedule->date, $schedule);
                $temp = collect();
                $temp->put('' . $user->id . '', $mergeUser);
                $seat->users = $temp;
                $result->put('' . $user->seat_id .'', $seat);
            } else {
                if (isset($result[$user->seat_id]->users[$user->id])) {
                    if (isset($result[$user->seat_id]->users[$user->id]->schedules[$schedule->date])) {
                        $schedule->shift = config('site.shift.all');
                        $result[$user->seat_id]->users[$user->id]->schedules[$schedule->date] = $schedule;
                    } else {
                        $result[$user->seat_id]
                        ->users[$user->id]
                        ->schedules->put(
                            $schedule->date,
                            $schedule
                        );
                    }
                } else {
                    $mergeUser->schedules = collect();
                    $mergeUser->schedules->put($schedule->date, $schedule);
                    $result[$user->seat_id]->users->put($user->id, $mergeUser);
                }
            }
        }

        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $firstDay = date(date('Y') . '-' . date('m') . '-01');
        $lastDay = date(date('Y') . '-' . date('m') . '-' . date('t'));
            
        $users = User::join(DB::raw('
            (
                select seats.id as seat_id,
                    seats.name as seat_name,
                    work_schedules.date as date,
                    schedule_seat.shift as shift,
                    work_schedules.user_id as user_id
                from work_schedules, schedule_seat, seats
                where work_schedules.id = schedule_seat.work_schedule_id
                and schedule_seat.seat_id = seats.id
                and seats.location_id = ' . $id . '
                and (seats.usable != ' . config('site.disable_seat') . ' or seats.usable is null)
            ) as Schedules
        '), 'users.id', DB::raw('Schedules.user_id'))
            ->whereBetween('Schedules.date', [$firstDay, $lastDay])
            ->orderBy('Schedules.date')
            ->get();

        $result = $this->collectUsers($users);

        return $result;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
