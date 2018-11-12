<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\ProgramRepository;
use Carbon\CarbonPeriod;
use Carbon\Carbon;

class SittingCalendarController extends Controller
{

    public function __construct(
        LocationRepository $locationRepository,
        UserRepository $userRepository,
        WorkspaceRepository $workspaceRepository,
        ProgramRepository $programRepository
    ) {
        $this->location = $locationRepository;
        $this->user = $userRepository;
        $this->workspace = $workspaceRepository;
        $this->program = $programRepository;

        $this->middleware('checkLogin');
        $this->middleware('permission:seat-statistical')->only([
            'chooseWorkplace',
            'locationList',
            'locationAnalystic',
            'getAnalysticData',
            'detailLocation',
        ]);
    }

    public function chooseWorkplace()
    {
        $workspaces = $this->workspace->getWorkspaces();

        return view('admin.calendar.choose_workspace', compact('workspaces'));
    }

    public function locationList($workspaceId)
    {
        $workspace = $this->workspace->findOrFail($workspaceId);
        $locationList = $this->workspace->getListLocation($workspaceId);

        return view('admin.calendar.choose_location', compact('locationList', 'workspace'));
    }

    public function locationAnalystic(Request $request, $locationId)
    {
        $request->session()->forget('ws_program_id');
        $location = $this->location->findOrFail($locationId);
        $programs = $this->program->listProgram();
        if ($request->has('program_id')) {
            $request->session()->put('ws_program_id', $request->program_id);
        }

        return view('admin.calendar.analystic', compact('location', 'programs'));
    }

    public function getAnalysticData(Request $request, $locationId)
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
        $data = $this->location->getData($locationId, $filter);
        
        return $data;
    }

    public function detailLocation(Request $request, $locationId, $date)
    {
        $location = $this->location->findOrFail($locationId);
        $filter = [
            'location_id' => $locationId,
            'date' => $date,
        ];
        if ($request->has('program_id')) {
            $filter['program_id'] = $request->program_id;
        }
        if ($request->has('shift')) {
            $filter['shift'] = $request->shift;
        }
        $data = $this->location->getLocationDetail($filter);
        $programs = $this->program->listProgram();

        return view('admin.calendar.detailLocation', compact('data', 'location', 'date', 'programs'));
    }
}
