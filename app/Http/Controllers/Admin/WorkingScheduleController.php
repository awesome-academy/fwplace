<?php

namespace App\Http\Controllers\Admin;

use App\Repositories\UserRepository;
use App\Repositories\WorkingScheduleRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\ProgramRepository;
use Carbon\Carbon;

class WorkingScheduleController extends Controller
{
    protected $location;
    protected $workspace;
    protected $userRepository;
    protected $program;
    protected $workschedule;

    public function __construct(
        LocationRepository $locationRepository,
        WorkspaceRepository $workspaceRepository,
        UserRepository $userRepository,
        ProgramRepository $programRepository,
        WorkingScheduleRepository $workingScheduleRepository
    ) {
        $this->location = $locationRepository;
        $this->workspace = $workspaceRepository;
        $this->userRepository = $userRepository;
        $this->program = $programRepository;
        $this->workschedule = $workingScheduleRepository;
        $this->middleware('checkLogin');
        $this->middleware('permission:work-schedules')->only([
            'viewByWorkplace',
            'getData',
            'chooseWorkplace',
            'getOneDate',
        ]);
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

    public function chooseWorkplace()
    {
        $workspaces = $this->workspace->getWorkspaces();

        return view('admin.work_schedules.choose_workspace', compact('workspaces'));
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
