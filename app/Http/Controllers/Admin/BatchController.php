<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\BatchRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\PositionRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\BatchRequest;

class BatchController extends Controller
{
    protected $batch;
    
    public function __construct(
        BatchRepository $batch,
        ProgramRepository $programRepository,
        PositionRepository $positionRepository,
        WorkspaceRepository $workspaceRepository,
        UserRepository $userRepository
    ) {
        $this->batch = $batch;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->workspaceRepository = $workspaceRepository;
        $this->userRepository = $userRepository;
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
        $this->batch->update($request->only([
            'stop_day',
            'start_day',
            'position_id',
            'program_id',
            'workspace_id',
            'batch',
        ]), $id);

        return redirect()->route('batches.index');
    }

    public function show($id)
    {
        return $this->batch->delete($id);
    }

    public function create()
    {
        $programs = $this->programRepository->listprogramArray();
        $positions = $this->positionRepository->listpositionArray();
        $workspaces = $this->workspaceRepository->listWorkspaceArray();

        return view('admin.batches.create', compact('programs', 'positions', 'workspaces'));
    }

    public function store(BatchRequest $request)
    {
        $this->batch->create($request->all());

        return redirect()->route('batches.index');
    }

    public function destroy($id)
    {
        $this->batch->delete($id);
        $this->userRepository->deleteBatchId($id);
        
        return redirect()->route('batches.index');
    }
}
