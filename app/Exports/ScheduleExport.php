<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ScheduleExport implements FromView
{
    private $users;
    private $workspace;
    private $position;
    private $program;
    private $specialDays;

    public function __construct($users, $workspace, $position, $program, $specialDays)
    {
        $this->users = $users;
        $this->workspace = $workspace;
        $this->position = $position;
        $this->program = $program;
        $this->specialDays = $specialDays;
    }

    public function view(): View
    {
        return view('admin.work_schedules.export', [
            'users' => $this->users,
            'program' => $this->program,
            'position' => $this->position,
            'workspace' => $this->workspace,
            'specialDays' => $this->specialDays,
        ]);
    }
}
