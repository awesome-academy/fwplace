<?php

namespace App\Http\Controllers\Admin;

use DB;
use Storage;
use App\Models\Seat;
use App\Traits\Generating;
use App\Models\ScheduleSeat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use App\Http\Requests\LocationAddRequest;
use App\Repositories\WorkspaceRepository;
use App\Http\Requests\LocationUpdateRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\WorkSchedule;

class LocationController extends Controller
{
    protected $location;
    protected $workspace;

    use Generating;

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

        return redirect()->route('schedule.workplace.view', ['id' => $request->workspace_id]);
    }

    public function updateRowColumn(Request $request, $id)
    {
        $this->validate($request, [
            'row' => 'required|numeric|min:1',
            'column' => 'required|numeric|min:1',
        ]);

        DB::beginTransaction();
        
        try {
            $location = $this->location->findOrFail($id);
            $location->seat_per_row = $request->row;
            $location->seat_per_column = $request->column;
            $location->save();

            $renderSeats = $this->renderSeat($location);
            $seats =  [];

            foreach ($renderSeats as $row) {
                foreach ($row as $seat) {
                    $seats = array_merge($seats, [$seat]);
                }
            }

            ScheduleSeat::whereIn('id', function ($query) use ($seats) {
                $query->select('id')
                    ->from('seats')
                    ->whereNotIn('name', $seats);
            })->delete();

            Seat::whereNotIn('name', $seats)->where('location_id', $location->id)->delete();

            foreach ($renderSeats as $row) {
                foreach ($row as $seat) {
                    Seat::updateOrCreate(
                        [
                            'name' => $seat,
                            'location_id' => $location->id,
                        ],
                        [
                            'name' => $seat,
                            'location_id' => $location->id,
                        ]
                    );
                }
            }

            if ($request->has('seats')) {
                $seats = json_decode(json_encode($request->seats));

                foreach ($seats as $seat) {
                    Seat::where([
                        'name' => $seat->name,
                        'location_id' => $location->id,
                    ])->update([
                        'usable' => $seat->usable,
                    ]);
                }
            }

            if ($request->has('clearUsers')) {
                $clearUsers = json_decode(json_encode($request->clearUsers));
                $firstDay = date('Y') . '-' . date('m') . '-01';
                $lastDay = date('Y') . '-' . date('m') . '-' . date('t');
                foreach ($clearUsers as $user) {
                    $schedules = WorkSchedule::where('user_id', $user->user_id)
                                    ->whereBetween('date', [$firstDay, $lastDay])
                                    ->get()
                                    ->pluck('id');

                    ScheduleSeat::where('seat_id', $user->seat_id)
                        ->whereIn('work_schedule_id', $schedules)
                        ->delete();
                }
            }

            DB::commit();

            return redirect()->back();
        } catch (\Exception $exception) {
            DB::beginTransaction();
            
            return response()->json($exception->getMessage(), 500);
        }
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
