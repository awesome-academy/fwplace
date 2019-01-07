<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserFormRequest;
use App\Repositories\PositionRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

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

    public function __construct(
        UserRepository $userRepository,
        ProgramRepository $programRepository,
        PositionRepository $positionRepository,
        WorkspaceRepository $workspaceRepository,
        RoleRepository $roleRepository
    ) {
        $this->userRepository = $userRepository;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->workspaceRepository = $workspaceRepository;
        $this->roleRepository = $roleRepository;
    }

    public function index()
    {
        $programs = $this->programRepository->pluckProgram()->toArray();
        $positions = $this->positionRepository->getListAllowRegister()->toArray();
        $workspaces = $this->workspaceRepository->pluckWorkspace()->toArray();
        $roles = $this->roleRepository->pluckRole()->toArray();

        return view('auth.register', compact('programs', 'positions', 'workspaces', 'roles'));
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
        $data = $request->all();
        $data['password'] = bcrypt($request->password);
        $data['status'] = 0;
        $data['role'] = $this->roleRepository->getIdTrainee()->id;
        $user = $this->userRepository->create($data);
        Alert::success(trans('Register Member Successfully'), trans('Please Wait Active'));

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
}
