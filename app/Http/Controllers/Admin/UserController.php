<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Repositories\PositionRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkspaceRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    protected $userRepository;
    protected $programRepository;
    protected $positionRepository;
    protected $workspaceRepository;

    public function __construct(
        UserRepository $userRepository,
        ProgramRepository $programRepository,
        PositionRepository $positionRepository,
        WorkspaceRepository $workspaceRepository
    ) {
        $this->userRepository = $userRepository;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->workspaceRepository = $workspaceRepository;
        $this->middleware('checkTrainer')->except('index', 'create', 'store', 'edit', 'update', 'getListTrainee');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $programs = $this->programRepository->pluckProgram()->prepend('', config('site.prepend'));
        $positions = $this->positionRepository->pluckPosition()->prepend('', config('site.prepend'));
        $workspaces = $this->workspaceRepository->pluckWorkspace()->prepend('', config('site.prepend'));
        $users = $this->userRepository->newQuery();
        if ($request->has('name')) {
            $users->getListName($request->name);
        }

        if ($request->has('program_id') && $request->program_id != config('site.prepend')) {
            $users->getList('program_id', $request->program_id);
        }

        if ($request->has('workspace_id') && $request->workspace_id != config('site.prepend')) {
            $users->getList('workspace_id', $request->workspace_id);
        }

        if ($request->has('position_id') && $request->position_id != config('site.prepend')) {
            $users->getList('position_id', $request->position_id);
        }

        $users = $users->orderBy('created_at', 'DESC')->paginate(config('site.paginate_user'));

        return view('admin.user.index', compact('users', 'programs', 'positions', 'workspaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $programs = $this->programRepository->listprogramArray();
        $positions = $this->positionRepository->listpositionArray();
        $workspaces = $this->workspaceRepository->listWorkspaceArray();

        return view('admin.user.create', compact('positions', 'programs', 'workspaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserFormRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('avatar')) {
            $request->avatar->store(config('site.user.image'));
            $data['avatar'] = $request->avatar->hashName();
        }
        $data['password'] = bcrypt($request->password);
        $this->userRepository->create($data);
        Alert::success(trans('Add new User'), trans('Successfully'));

        return redirect('admin/users');
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

        return view('admin.user.edit', compact('positions', 'programs', 'workspaces', 'user'));
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
        alert()->success(__('Edit Employee'), __('Successfully!!!'));

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userRepository->delete($id);
        Alert::success(trans('Delete Employee'), trans('Successfully'));

        return redirect('admin/users');
    }

    public function getListTrainee($id, Request $request)
    {
        $programs = $this->programRepository->pluckProgram()->prepend('', config('site.prepend'));
        $positions = $this->positionRepository->pluckPosition()->prepend('', config('site.prepend'));
        $workspaces = $this->workspaceRepository->pluckWorkspace()->prepend('', config('site.prepend'));
        $trainees = $this->userRepository->newQuery();
        if ($request->has('name')) {
            $trainees->getListName($request->name);
        }

        if ($request->has('program_id') && $request->program_id != config('site.prepend')) {
            $trainees->getList('program_id', $request->program_id);
        }

        if ($request->has('workspace_id') && $request->workspace_id != config('site.prepend')) {
            $trainees->getList('workspace_id', $request->workspace_id);
        }

        if ($request->has('position_id') && $request->position_id != config('site.prepend')) {
            $trainees->getList('position_id', $request->position_id);
        }
        $trainees = $trainees->getListTrainee($id);

        return view('admin.user.traineelist', compact('trainees', 'positions', 'programs', 'workspaces'));
    }
}
