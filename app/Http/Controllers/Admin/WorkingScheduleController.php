<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\LocationRepository;
use App\Repositories\PositionRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\WorkingScheduleRepository;
use App\Models\SpecialDay;

class WorkingScheduleController extends Controller
{
    protected $location;
    protected $workspace;
    protected $userRepository;
    protected $program;
    protected $workschedule;
    protected $position;

    public function __construct(
        LocationRepository $locationRepository,
        WorkspaceRepository $workspaceRepository,
        UserRepository $userRepository,
        ProgramRepository $programRepository,
        WorkingScheduleRepository $workingScheduleRepository,
        PositionRepository $positionRepository
    ) {
        $this->location = $locationRepository;
        $this->workspace = $workspaceRepository;
        $this->userRepository = $userRepository;
        $this->program = $programRepository;
        $this->workschedule = $workingScheduleRepository;
        $this->position = $positionRepository;
        $this->middleware('checkLogin');
        $this->middleware('permission:work-schedules')->only([
            'viewByWorkplace',
            'getData',
            'getOneDate',
        ]);
    }

    public function index(Request $request)
    {
        $users = $this->workschedule->getByMonth($request);
        $positions = $this->position->pluck('name', 'id');
        $programs = $this->program->pluck('name', 'id');
        $workspaces = $this->workspace->pluck('name', 'id');

        return view('admin.work_schedules.index', compact(
            'users',
            'positions',
            'programs',
            'workspaces'
        ));
    }

    public function viewByWorkplace($workspaceId)
    {
        $workspace = $this->workspace->findOrFail($workspaceId);
        $locationList = $this->workspace->getListLocation($workspaceId);

        return view('admin.work_schedules.view_location', compact('workspace', 'locationList'));
    }

    public function getData(Request $request, $workspaceId)
    {
        $workspace = $this->workspace->findOrFail($workspaceId);
        $this->validate(
            $request,
            [
                'start' => 'required',
                'end' => 'required',
            ]
        );
        $filter = [
            'start' => $request->start,
            'end' => $request->end,
        ];
        if ($request->session()->has('ws_program_id')) {
            $filter['program_id'] = $request->session()->get('ws_program_id');
        }
        $data = $this->workspace->getData($workspaceId, $filter);

        return $data;
    }

    public function viewByUser($userId)
    {
        $user = $this->userRepository->findOrFail($userId);

        return view('admin.user.timesheet', compact('user'));
    }

    public function getDataUser(Request $request, $userId)
    {
        $this->validate(
            $request,
            [
                'start' => 'required',
                'end' => 'required',
            ]
        );
        $dates = [
            'start' => $request->start,
            'end' => $request->end,
        ];
        $data = $this->userRepository->getDataUserTimesheet($userId, $dates);

        return $data;
    }

    public function getOneDate(Request $request, $workspaceId)
    {
        $workspace = $this->workspace->findOrFail($workspaceId);
        $this->validate(
            $request,
            [
                'date' => 'required|date',
            ]
        );
        if (Carbon::parse($request->date)->isWeekend()) {
            return response()->json(null);
        }
        $data = $this->workspace->getOneDate($workspaceId, $request->date);

        return $data;
    }

    public function getScheduleByLocation($locationId)
    {
        $location = $this->location->findOrFail($locationId);

        return view('admin.work_schedules.schedule_by_location', compact('location'));
    }

    public function getScheduleData(Request $request, $locationId)
    {
        $location = $this->location->findOrFail($locationId);

        $this->validate(
            $request,
            [
                'start' => 'required',
                'end' => 'required',
            ]
        );
        $filter = [
            'start' => $request->start,
            'end' => $request->end,
        ];
        if ($request->session()->has('ws_program_id')) {
            $filter['program_id'] = $request->session()->get('ws_program_id');
        }

        $data = $this->location->setDataForCalenDar($location, $filter);

        return $data;
    }
}
