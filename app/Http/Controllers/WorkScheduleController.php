<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Repositories\WorkingScheduleRepository;
use App\Repositories\LocationRepository;

class WorkScheduleController extends Controller
{
    public function __construct(
        WorkingScheduleRepository $workingScheduleRepository,
        LocationRepository $locationRepository
    ) {
        $this->workingSchedule = $workingScheduleRepository;
        $this->locationRepository = $locationRepository;

        $this->middleware('checkLogin');
        $this->middleware('permission:register-work-schedules')->only(['index', 'registerWork']);
    }

    public function index()
    {
        $dates = [];
        for ($i = 0; $i < 31; $i++) {
            $day = Carbon::now()->startOfMonth()->addDay($i);
            if (!$day->isWeekend()) {
                $dates[] = [
                    'date' => $day->format('Y-m-d'),
                    'day' => $day->format('l'),
                    'format' => $day->format('d-m-Y'),
                ];
            } else {
                $dates[] = [
                    'date' => $day->format('Y-m-d'),
                    'day' => $day->format('l'),
                    'format' => $day->format('d-m-Y'),
                    'weekend' => true,
                ];
            }
        }

        $locations = $this->locationRepository->getByWorkspace(Auth::user()->workspace_id);
        $data = $this->workingSchedule->getUserSchedule(Auth::user()->id);
        $dataLocation = $this->workingSchedule->getLocation(Auth::user()->id);

        return view('users.registerworkschedules', compact('dates', 'data', 'locations', 'dataLocation'));
    }

    public function registerWork(Request $request)
    {
        $data = $request->all();
        foreach ($data['shift'] as $key => $value) {
            $request->user()->workSchedules()->updateOrCreate(
                [
                    'date' => $key,
                ],
                [
                    'location_id' => $data['location'][$key],
                    'shift' => $value,
                ]
            );
        }

        return redirect()->back();
    }
}
