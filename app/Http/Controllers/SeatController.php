<?php

namespace App\Http\Controllers;

use App\Repositories\LocationRepository;
use App\Repositories\SeatRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkspaceRepository;
use Illuminate\Http\Request;
use App\Traits\Generating;
use Illuminate\Support\Facades\Auth;
use DB;

class SeatController extends Controller
{
    use Generating;

    protected $seatRepository;
    protected $workspaceRepository;
    protected $userRepository;
    protected $locationRepository;

    public function __construct(
        SeatRepository $seatRepository,
        WorkspaceRepository $workspaceRepository,
        UserRepository $userRepository,
        LocationRepository $locationRepository
    ) {
        $this->seatRepository = $seatRepository;
        $this->workspaceRepository = $workspaceRepository;
        $this->userRepository = $userRepository;
        $this->locationRepository = $locationRepository;
    }

    public function getListOfSeats(Request $request)
    {
        $day = $request->day ?? config('site.default_day');
        $day = $this->getDayIfWeekend($day);
        $workspace = $this->workspaceRepository->findOrFail(Auth::user()->workspace_id);
        $locations = $workspace->locations;
        $renderSeat = $this->renderSeat($workspace);
        $colorLocation = $this->getColorLocationByDay($locations, $day);
        $dates = $this->getWorkingDatesInMonth();
        $seatOfUser = json_encode($this->userRepository->getSeatOfUserByDay($day, Auth::id())->toArray());
        $schedules = json_encode($this->getScheduleByUser()->toArray());

        return view('users.register_seat', compact(
            'renderSeat',
            'colorLocation',
            'dates',
            'seatOfUser',
            'schedules',
            'workspace'
        ));
    }

    public function getSeatStatusByDay(Request $request)
    {
        $day = $request->day ?? config('site.default_day');
        $day = $this->getDayIfWeekend($day);
        $workspace = $this->workspaceRepository->findOrFail($request->workspace_id);
        $locations = $workspace->locations;
        $colorLocation = $this->getColorLocationByDay($locations, $day);

        return $colorLocation;
    }

    public function registerSeat(Request $request)
    {
        $curSeat = $request->cur_seat;
        DB::transaction(function () use ($request, $curSeat) {
            if ($curSeat != 0) {
                $request->user()->seats()->detach($curSeat);
                $request->user()->seats()->attach($request->seat_id, [
                    'registration_date' => $request->day,
                    'shift' => $request->shift,
                ]);
            } else {
                $request->user()->seats()->attach($request->seat_id, [
                    'registration_date' => $request->day,
                    'shift' => $request->shift,
                ]);
            }
        });
        alert()->success('Success', __('Register Successfully!!!'));

        return redirect()->route('register.seat');
    }
}
