<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\BatchRequest;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Repositories\BatchRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\PositionRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;

class BatchController extends Controller
{
    protected $batch;
    
    public function __construct(
        BatchRepository $batch,
        ProgramRepository $programRepository,
        PositionRepository $positionRepository,
        WorkspaceRepository $workspaceRepository,
        UserRepository $userRepository,
        SubjectRepositoryInterface $subjectRepository
    ) {
        $this->batch = $batch;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->workspaceRepository = $workspaceRepository;
        $this->userRepository = $userRepository;
        $this->subject = $subjectRepository;
    }
    
    public function index()
    {
        $batches = $this->batch->with(['program', 'position', 'workspace', 'subjects'])->get();

        return view('admin.batches.index', compact('batches'));
    }

    public function edit($id)
    {
        $programs = $this->programRepository->listprogramArray();
        $positions = $this->positionRepository->listpositionArray();
        $workspaces = $this->workspaceRepository->listWorkspaceArray();
        $batch = $this->batch->with('program', 'position', 'workspace', 'subjects')->find($id);
        $subjects = $this->subject->getNameSubject()->pluck('name', 'id');

        return view('admin.batches.edit', compact('batch', 'programs', 'positions', 'workspaces', 'subjects'));
    }

    public function update(BatchRequest $request, $id)
    {
        DB::beginTransaction();

        try {
            $this->batch->update($request->only([
                'stop_day',
                'start_day',
                'position_id',
                'program_id',
                'workspace_id',
            ]), $id);

            $batch = $this->batch->findOrFail($id);

            $batch->subjects()->sync($request->subjects);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            return $exception;
        }

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
        $subjects = $this->subject->getNameSubject()->pluck('name', 'id');

        return view('admin.batches.create', compact('programs', 'positions', 'workspaces', 'subjects'));
    }

    public function store(BatchRequest $request)
    {
        // return $request->all();
        $lastestBatch = $this->batch->lastestBatch($request->all());
        $data = $request->only('workspace_id', 'position_id', 'program_id', 'start_day', 'stop_day');
        $data = array_merge($data, ['batch' => 1]);
        if ($lastestBatch) {
            $data['batch'] = $lastestBatch->batch + 1;
        }
        
        DB::beginTransaction();
        
        try {
            $batch = $this->batch->create($data);

            $batch->subjects()->sync($request->subjects);
            
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            return $exception;
        }

        return redirect()->route('batches.index');
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $batch = $this->batch->findOrFail($id);
            $batch->subjects()->sync([]);
            $this->batch->delete($id);
            $this->userRepository->deleteBatchId($id);

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();

            return $exception;
        }
        
        return redirect()->route('batches.index');
    }
}
