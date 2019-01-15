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

    public function __construct($users, $workspace, $position, $program)
    {
        $this->users = $users;
        $this->workspace = $workspace;
        $this->position = $position;
        $this->program = $program;
    }

    public function view(): View
    {
        return view('admin.work_schedules.export', [
            'users' => $this->users,
            'program' => $this->program,
            'position' => $this->position,
            'workspace' => $this->workspace,
        ]);
    }
}
