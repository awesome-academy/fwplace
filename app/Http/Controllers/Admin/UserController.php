<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\UserFormRequest;
use App\Models\Position;
use App\Models\Program;
use App\Models\Workspace;
use App\Repositories\PositionRepository;
use App\Repositories\ProgramRepository;
use App\Repositories\UserRepository;
use App\Repositories\WorkspaceRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    protected $userRepository;
    protected $programRepository;
    protected $positionRepository;
    protected $workspaceRepository;

    public function __construct(UserRepository $userRepository, ProgramRepository $programRepository, PositionRepository $positionRepository, WorkspaceRepository $workspaceRepository)
    {
        $this->userRepository = $userRepository;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->workspaceRepository = $workspaceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->userRepository->get();

        return view('admin.user.index', compact('users'));
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
        alert()->success(__('Edit User'), __('Successfully!!!'));

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
        Alert::success(trans('Delete User'), trans('Successfully'));

        return redirect('admin/users');
    }
}