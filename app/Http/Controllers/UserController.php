<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\BatchRepository;
use App\Http\Requests\UserFormRequest;
use App\Repositories\ReportRepository;
use App\Repositories\ProgramRepository;
use Illuminate\Support\Facades\Storage;
use App\Repositories\PositionRepository;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\WorkspaceRepository;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $userRepository;
    protected $programRepository;
    protected $positionRepository;
    protected $workspaceRepository;
    protected $roleRepository;
    protected $batchRepository;
    protected $reportRepository;

    public function __construct(
        UserRepository $userRepository,
        ProgramRepository $programRepository,
        PositionRepository $positionRepository,
        WorkspaceRepository $workspaceRepository,
        RoleRepository $roleRepository,
        BatchRepository $batchRepository,
        ReportRepository $reportRepository
    ) {
        $this->userRepository = $userRepository;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->workspaceRepository = $workspaceRepository;
        $this->roleRepository = $roleRepository;
        $this->batchRepository = $batchRepository;
        $this->reportRepository = $reportRepository;
    }

    public function index()
    {
        $programs = $this->programRepository->pluckProgram()->toArray();
        $positions = $this->positionRepository->getListAllowRegister()->toArray();
        $workspaces = $this->workspaceRepository->pluckWorkspace()->toArray();
        $roles = $this->roleRepository->pluckRole()->toArray();
        $batches = $this->batchRepository->listBatchesArray();

        return view('auth.register', compact('programs', 'positions', 'workspaces', 'roles', 'batches'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        DB::Transaction(function () use ($request) {
            $data = $request->all();
            $data['password'] = bcrypt($request->password);
            $data['status'] = 0;
            $data['role'] = $this->roleRepository->getIdTrainee()->id;
            $user = $this->userRepository->create($data);

            if ($data['batch_id'] != '') {
                $batch = $this->batchRepository->findOrFail($data['batch_id']);
                $subjects = $batch->subjects;
                foreach ($subjects as $subject) {
                    for ($i = 1; $i <= $subject->day; $i++) {
                        Report::create([
                            'user_id' => $user->id,
                            'subject_id' => $subject->id,
                            'day' => $i,
                            'content' => ' ',
                            'link' => ' ',
                            'test_link' => ' ',
                            'lesson' => ' ',
                            'status' => ' ',
                        ]);
                    }
                }
            }
            Alert::success(trans('Register Member Successfully'), trans('Please Wait Active'));
        });

        return redirect('/login');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $programs = $this->programRepository->listprogramArray();
        $positions = $this->positionRepository->listpositionArray();
        $workspaces = $this->workspaceRepository->listWorkspaceArray();
        $user = $this->userRepository->findOrFail($id);
        $trainers = $this->userRepository->getSelectTrainer($user->program_id);

        return view('users.edit', compact('positions', 'programs', 'workspaces', 'user', 'trainers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserFormRequest $request, $id)
    {
        $user = $this->userRepository->findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            Storage::delete(config('site.user.image') . $user->avatar);
            $request->avatar->store(config('site.user.image'));
            $data['avatar'] = $request->avatar->hashName();
        }
        $this->userRepository->update($data, $id);
        alert()->success(__('Edit User'), __('Successfully!!!'));

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function selectTrainer(Request $request)
    {
        if (!$request->has('program_id')) {
            return null;
        }
        $trainers = $this->userRepository->getSelectTrainer($request->program_id);

        return json_encode($trainers);
    }

    public function selectbatch(Request $request)
    {
        $batches = $this->batchRepository->with(['position', 'program', 'workspace'])
            ->where('workspace_id', '=', $request->workspace_id)->where('position_id', '=', $request->position_id)
            ->where('program_id', '=', $request->program_id)->get();

        return $batches;
    }

    public function currentUser(Request $request)
    {
        return new UserResource(Auth::user());
    }
}
