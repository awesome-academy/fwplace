<?php

namespace App\Http\Controllers;

use App\Repositories\SeatRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Repositories\WorkingScheduleRepository;
use App\Repositories\LocationRepository;
use DB;
use Exception;

class WorkScheduleController extends Controller
{
    protected $workingSchedule;
    protected $locationRepository;
    protected $seatRepository;

    public function __construct(
        WorkingScheduleRepository $workingScheduleRepository,
        LocationRepository $locationRepository,
        SeatRepository $seatRepository
    ) {
        $this->workingSchedule = $workingScheduleRepository;
        $this->locationRepository = $locationRepository;
        $this->seatRepository = $seatRepository;
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
        $seats = Auth::user()->workspace->seats()->pluck('seats.name', 'seats.id');
        $data = $this->workingSchedule->getUserSchedule(Auth::user()->id);
        $dataLocation = $this->workingSchedule->getLocation(Auth::user()->id);
        $dataSeat = Auth::user()->seats()->pluck('seat_id', 'registration_date');
        $registered = count($data) == config('site.disallow_register') ? false : true;

        return view('users.registerworkschedules', compact(
            'dates',
            'data',
            'locations',
            'dataLocation',
            'dataSeat',
            'seats',
            'registered'
        ));
    }

    public function registerWork(Request $request)
    {
        try {
            $data = $request->all();
            foreach ($data['shift'] as $key => $value) {
                DB::transaction(function () use ($request, $data, $key, $value) {
                    $request->user()->workSchedules()->updateOrCreate(
                        [
                            'date' => $key,
                        ],
                        [
                            'location_id' => $data['location'][$key],
                            'shift' => $value,
                        ]
                    );
                    $request->user()->seats()->attach($data['seat'][$key], [
                        'registration_date' => $key,
                        'shift' => $value,
                    ]);
                });
            }

            return redirect()->back();
        } catch (Exception $exception) {
            return back()->with('error', __('Not found error'));
        }
    }

    public function getSeat(Request $request)
    {
        $listOfSeats = $this->seatRepository->getArraySeatByLocationId($request->location_id);

        return json_encode($listOfSeats);
    }

    public function getSeatByDay(Request $request)
    {
        $locationId = $request->location_id;
        $date = $request->date;
        $shift = $request->shift;
        $listOfSeats = $this->seatRepository->getSeatByLocationId($locationId);
        $listOfUnusedSeats = [];

        foreach ($listOfSeats as $seat) {
            if (!$seat->checkUsedSeat($date, $shift)) {
                $listOfUnusedSeats[$seat->id] = $seat->name;
            }
        }

        return json_encode($listOfUnusedSeats);
    }
}
