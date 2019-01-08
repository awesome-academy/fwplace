<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BatchRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\PositionRepository;
use App\Repositories\ProgramRepository;
use App\Http\Requests\BatchRequest;

class BatchController extends Controller
{
    protected $batch;
    
    public function __construct(
        BatchRepository $batch,
        ProgramRepository $programRepository,
        PositionRepository $positionRepository,
        WorkspaceRepository $workspaceRepository
    ) {
        $this->batch = $batch;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->workspaceRepository = $workspaceRepository;
    }
    
    public function index()
    {
        $batches = $this->batch->with(['program', 'position', 'workspace'])->get();

        return view('admin.batches.index', compact('batches'));
    }

    public function edit($id)
    {
        $programs = $this->programRepository->listprogramArray();
        $positions = $this->positionRepository->listpositionArray();
        $workspaces = $this->workspaceRepository->listWorkspaceArray();
        $batch = $this->batch->with('program', 'position', 'workspace')->find($id);

        return view('admin.batches.edit', compact('batch', 'programs', 'positions', 'workspaces'));
    }

    public function update(BatchRequest $request, $id)
    {
        $this->batch->update($request->all());

        return redirect()->route('batch.index');
    }

    public function show($id)
    {
        return $this->batch->delete($id);
    }
}
