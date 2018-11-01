<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use App\Repositories\WorkspaceRepository;
use Illuminate\Validation\Rule;
use Storage;
use App\Http\Requests\LocationAddRequest;
use App\Http\Requests\LocationUpdateRequest;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class LocationController extends Controller
{
    protected $location;
    protected $workspace;

    public function __construct(LocationRepository $locationRepository, WorkspaceRepository $workspaceRepository)
    {
        $this->location = $locationRepository;
        $this->workspace = $workspaceRepository;
        $this->middleware('checkTrainer')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filter = [
            'workspace_id' => null,
            'name' => null,
        ];

        if ($request->has('workspace_id') && $request->has('name')) {
            $filter = [
                'workspace_id' => $request->workspace_id,
                'name' => $request->name,
            ];
        }
        $workspaces = $this->workspace->listWorkspaceArray();
        $locations = $this->location->listLocation($filter);

        return view('admin.locations.list', compact('locations', 'workspaces'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $workspaces = $this->workspace->listWorkspaceArray();

        return view('admin.locations.create', compact('workspaces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LocationAddRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('image')) {
            $request->image->store(config('site.location.image'));
            $data['image'] = $request->image->hashName();
        }
        $save = $this->location->create($data);
        alert()->success(__('Add Location'), __('Successfully!!!'));

        return redirect()->route('locations.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $workspaces = $this->workspace->listWorkspaceArray();
        $location = $this->location->findOrFail($id);

        return view('admin.locations.edit', compact('workspaces', 'location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(LocationUpdateRequest $request, $id)
    {
        $location = $this->location->findOrFail($id);
        $data = $request->all();
        if ($request->hasFile('image')) {
            Storage::delete(config('site.location.image') . $location->image);
            $request->image->store(config('site.location.image'));
            $data['image'] = $request->image->hashName();
        }
        $save = $this->location->update($data, $id);
        alert()->success(__('Edit Location'), __('Successfully!!!'));

        return redirect()->route('locations.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $location = $this->location->findOrFail($id);

            DB::transaction(function () use ($id, $location) {
                $location->seats()->delete();
                $location->delete();
            });
            alert()->success(__('Delete Location'), __('Successfully!!!'));

            return redirect()->back();
        } catch (ModelNotFoundException $exception) {
            return back()->with('error', __('Not found error'));
        }
    }
}
