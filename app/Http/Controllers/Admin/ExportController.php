<?php

namespace App\Http\Controllers\Admin;

use App\Models\Program;
use App\Models\Position;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use App\Exports\ScheduleExport;
use App\Http\Controllers\Controller;
use App\Repositories\WorkingScheduleRepository;

class ExportController extends Controller
{
    private $excel;
    protected $workschedule;

    public function __construct(
        WorkingScheduleRepository $workingScheduleRepository,
        Excel $excel
    ) {
        $this->workschedule = $workingScheduleRepository;
        $this->excel = $excel;
        $this->middleware('checkLogin');
        $this->middleware('permission:work-schedules')->only([
            'view',
        ]);
    }

    public function export(Request $request)
    {
        $users = $this->workschedule->getByMonth($request);
        $workspace = ($request->has('workspace') && $request->workspace !== null)
                        ? Workspace::findOrFail($request->workspace)->name
                        : '';

        $program = ($request->has('program') && $request->program !== null)
                        ? Program::findOrFail($request->program)->name
                        : '';
                        
        $position = ($request->has('position') && $request->position !== null)
                        ? Position::findOrFail($request->position)->name
                        : '';

        return $this->excel->download(new ScheduleExport($users, $workspace, $position, $program), 'schedules.xls');
    }
}
