<?php

namespace App\Http\Controllers\Admin;

use DB;
use Entrust;
use Validator;
use Carbon\Carbon;
use App\Models\Seat;
use App\Models\User;
use Mockery\Exception;
use App\Traits\Generating;
use App\Models\WorkSchedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\SeatRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ProgramInterface;
use Illuminate\Support\Facades\Storage;
use App\Repositories\LocationRepository;
use App\Repositories\PositionRepository;
use RealRashid\SweetAlert\Facades\Alert;
use App\Repositories\WorkspaceRepository;
use App\Http\Requests\DesignDiagramRequests;
use App\Repositories\DesignDiagramRepository;
use App\Repositories\WorkingScheduleRepository;
use App\Http\Resources\WorkScheduleSeatResource;
use App\Models\ScheduleSeat;

class DiagramController extends Controller
{
    use Generating;

    protected $userRepository;
    protected $programRepository;
    protected $positionRepository;
    protected $locationRepository;
    protected $designDiagramRepository;
    protected $workingScheduleRepository;
    protected $workspace;
    protected $seat;

    public function __construct(
        LocationRepository $locationRepository,
        WorkspaceRepository $workspaceRepository,
        SeatRepository $seatRepository,
        UserRepository $userRepository,
        ProgramInterface $programRepository,
        PositionRepository $positionRepository,
        DesignDiagramRepository $designDiagramRepository,
        WorkingScheduleRepository $workingScheduleRepository
    ) {
        $this->locationRepository = $locationRepository;
        $this->workspace = $workspaceRepository;
        $this->seat = $seatRepository;
        $this->userRepository = $userRepository;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->designDiagramRepository = $designDiagramRepository;
        $this->workingScheduleRepository = $workingScheduleRepository;
    }

    public function getAvailableSeatsByDate(Request $request, $id)
    {
        $user = Auth::user();
        $firstDay = date('Y') . '-' . date('m') . '-01';
        $lastDay = date('Y') . '-' . date('m') . '-' . date('t');
        $workSchedules = WorkSchedule::where('user_id', $user->id)
                            ->with([
                                'seats' => function ($query) {
                                    $query->orderBy('schedule_seat.shift');
                                },
                            ])
                            ->where('location_id', $id)
                            ->whereBetween('date', [$firstDay, $lastDay])
                            ->get();

        foreach ($workSchedules as $schedule) {
            switch ($schedule->shift) {
                case config('site.shift.all'):
                    //where not in
                    $schedule->morningSeats = $this->seat
                                                ->getAvailableSeats(
                                                    $schedule,
                                                    $id,
                                                    config('site.shift.morning')
                                                );
                    $schedule->afternoonSeats = $this->seat
                                                ->getAvailableSeats(
                                                    $schedule,
                                                    $id,
                                                    config('site.shift.afternoon')
                                                );
                    break;
                case config('site.shift.morning'):
                    $schedule->morningSeats = $this->seat
                                                ->getAvailableSeats(
                                                    $schedule,
                                                    $id,
                                                    config('site.shift.morning')
                                                );
                    break;
                case config('site.shift.afternoon'):
                    $schedule->afternoonSeats = $this->seat
                                                ->getAvailableSeats(
                                                    $schedule,
                                                    $id,
                                                    config('site.shift.afternoon')
                                                );
                    break;
            }
        }

        return WorkScheduleSeatResource::collection($workSchedules);
    }

    public function generateDiagram(Request $request, $id)
    {
        $location = $this->locationRepository->findOrFail($id);
        $renderSeat = $this->seat->where('location_id', $id)->get()->pluck('usable', 'name');

        $renderSeat = $this->groupSeatsByRow($renderSeat, $location);

        $dates = $this->getAvailableSeatsByDate($request, $id);

        return view('test.workspace.generate', compact(
            'renderSeat',
            'dates',
            'location'
        ));
    }

    //return color location
    public function getLocationColors(Request $request, $idWorkspace)
    {
        $workspace = $this->workspace->findOrFail($idWorkspace);
        $locations = $workspace->locations;
        $colorLocation = $this->getColorLocation($locations);

        if ($request->ajax()) {
            return $colorLocation;
        }
    }

    public function saveLocation(Request $request, $id)
    {
        $this->validate($request, [
            'seats' => 'required',
            'name' => 'required',
        ]);

        $this->workspace->findOrFail($id);
        $seats = explode(',', $request->seats);
        DB::transaction(function () use ($request, $seats, $id) {
            $location = $this->locationRepository->create([
                'name' => $request->name,
                'workspace_id' => $id,
                'color' => $request->color,
            ]);

            foreach ($seats as $value) {
                $this->seat->create([
                    'name' => $value,
                    'location_id' => $location->id,
                    'usable' => isset($request->usable) ?? false,
                ]);
            }
        });

        return redirect()->back();
    }

    public function saveAjaxLocation(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'seat' => 'required',
        ]);

        $seats = $request->seat;
        foreach ($seats as $value) {
            $this->seat->create([
                'name' => $value,
                'location_id' => $request->id,
            ]);
        }

        $data = $this->locationRepository->findOrFail($request->id);

        return response()->json($data);
    }

    public function detail($id)
    {
        $workspace = $this->workspace->findOrFail($id);
        $renderSeat = $this->renderSeat($workspace);
        $locations = $workspace->locations;
        $colorLocation = $this->getColorLocation($locations);

        return view('test.workspace.detail', compact('workspace', 'renderSeat', 'colorLocation', 'locations'));
    }

    public function saveInfoLocation(Request $request)
    {
        $seatUserId = $this->seat->findOrFail($request->seat_id);
        $checkUserId = unserialize($seatUserId->user_id);
        if (is_array($checkUserId) && !empty($checkUserId)) {
            $request->merge([ 'user_id' => serialize(array_merge($checkUserId, $request->user_id)) ]);
        } else {
            $request->merge([ 'user_id' => serialize($request->user_id) ]);
        }
        $data = $request->only('user_id', 'seat_id');
        $this->seat->update($data, $request->seat_id);
        Alert::success(trans('Edit Program'), trans('Successfully!!!'));

        return redirect()->back();
    }

    public function editInfoLocation(Request $request)
    {
        $data = $this->userRepository->where('id', $request->user_id)->first();

        return response()->json($data);
    }

    public function imageMap(Request $request, $id)
    {
        $workspace = $this->workspace->findOrFail($id);
        $diagram = $this->designDiagramRepository->where('workspace_id', $id)->first();

        return view('test.workspace.image_map', compact('workspace', 'diagram'));
    }

    public function saveDesignDiagram(DesignDiagramRequests $request)
    {
        $data = $request->only('content', 'workspace_id');
        DB::beginTransaction();
        try {
            $html = new \DomDocument();
            $html->loadHtml($data['content']);
            $nodes = $html->getElementsByTagName('area');
            $locationNames = [];
            foreach ($nodes as $node) {
                array_push($locationNames, $node->getAttribute('title'));
            }

            $ids = [];

            foreach ($locationNames as $name) {
                $location = $this->locationRepository
                    ->makeModel()
                    ->updateOrCreate(
                        [
                            'name' => $name,
                            'workspace_id' => $data['workspace_id'],
                        ],
                        [
                            'name' => $name,
                            'workspace_id' => $data['workspace_id'],
                        ]
                    );

                array_push($ids, $location->id);
            }

            $this->locationRepository->makeModel()
                ->where('workspace_id', $request->workspace_id)
                ->whereNotIn('id', $ids)
                ->delete();

            $i = 0;
            foreach ($nodes as $node) {
                $node->setAttribute('href', route('generate', ['id' => $ids[$i]]));
                $i++;
            }

            $data['content'] = $html->saveHtml($html->getElementsByTagName('map')->item(0));

            $this->designDiagramRepository
                ->makeModel()
                ->updateOrCreate(
                    [
                        'workspace_id' => $data['workspace_id'],
                    ],
                    $data
                );

            if ($request->diagram) {
                $request->diagram->store(config('site.workspace.image'));

                $data['diagram'] = $request->diagram->hashName();

                $workspace = $this->workspace->findOrFail($request->workspace_id);

                $workspace->image = $data['diagram'];

                $workspace->save();
            }

            DB::commit();
            Alert::success(trans('Add success'), trans('Successfully!!!'));

            return redirect()->route('list_diagram');
        } catch (Exception $e) {
            DB::rollback();

            Alert::error(trans('Add error'), __('Required'));
        }
    }

    public function listDiagram()
    {
        $listDiagram = $this->designDiagramRepository->getListDiagram();

        return view('test.workspace.diagram_list', compact('listDiagram'));
    }

    public function diagramDetail($id)
    {
        $diagramDetail = $this->designDiagramRepository->findOrFail($id);

        return view('test.workspace.diagram_detail', compact('diagramDetail'));
    }

    public function avatarInfo(Request $request, $id)
    {
        $data = $this->userRepository->findOrFail($id);

        return response()->json($data);
    }

    public function editInfoUser(Request $request)
    {
        DB::beginTransaction();
        try {
            $checkUser = $this->seat->findOrFail($request->seat_id);
            $checkUserId = unserialize($checkUser->user_id);
            foreach ($checkUserId as $key => $val) {
                if ($request->user_id == $val) {
                    $arr = array_replace(
                        $checkUserId,
                        array_fill_keys(
                            array_keys($checkUserId, $val),
                            $request->edit_userId
                        )
                    );
                }
            }
            $request->merge(['user_id' => serialize($arr)]);
            $data = $request->only('user_id', 'seat_id');
            $this->seat->update($data, $request->seat_id);
            DB::commit();

            Alert::success(trans('Edit Program'), trans('Successfully!!!'));

            return redirect()->back();
        } catch (Exception $e) {
            DB::rollback();

            Alert::error(trans('Add error'), __('Required'));
        }
    }

    public function editSeat(Request $request)
    {
        $this->validate($request, [
            'seat_id' => 'required',
            'color' => 'required',
        ]);

        $id = $request->seat_id;
        $color = $request->color;

        $seat = $this->seat->findOrFail($id);
        $location = $this->locationRepository->findOrFail($seat->location_id);

        $location->color = $color;

        $location->save();

        return redirect()->back();
    }

    public function deleteSeat(Request $request)
    {
        $this->validate($request, [
            'seat_id' => 'required',
        ]);

        return $this->seat->deleteSeat($request->seat_id);
    }

    public function showDesignWithoutDiagram(Request $request, $id)
    {
        $workspace = $this->workspace->findOrFail($id);

        return view('test.workspace.design_without_diagram', compact('workspace'));
    }

    public function getLocationsArray($object, $workspaceId)
    {
        $keys = [];

        foreach ($object as $key => $val) {
            $newArray = [];
            $newArray['name'] =  $key;
            $newArray['color'] =  $val->color;
            $newArray['workspace_id'] =  $workspaceId;
            $newArray['usable'] = $val->usable;
            array_push($keys, $newArray);
        }

        return $keys;
    }

    public function saveDesignWithoutDiagram(Request $request)
    {
        $this->validate($request, [
            'content' => 'required',
            'workspace_id' => 'required|exists:workspaces,id',
            'row' => 'nullable|integer',
            'column' => 'nullable|integer',
        ]);

        $data = $request->only('content', 'workspace_id');

        $data['content']= json_encode($data['content']);

        $content = json_decode($data['content']);

        $locations = $this->getLocationsArray($content, $data['workspace_id']);
        
        DB::beginTransaction();
        try {
            if ($request->has('row') && $request->has('column')) {
                $workspace = $this->workspace->findOrFail($request->workspace_id);
                $workspace->update([
                    'seat_per_row' => $request->row,
                    'seat_per_column' => $request->column,
                ]);
            }

            $ids = [];

            foreach ($locations as $location) {
                $location = $this->locationRepository
                    ->makeModel()
                    ->updateOrCreate(
                        [
                            'name' => $location['name'],
                            'workspace_id' => $location['workspace_id'],
                        ],
                        $location
                    );

                array_push($ids, $location->id);
            }

            $i = 0;
            foreach ($content as $key => $val) {
                $val->id = $ids[$i];
                $i++;
            }

            $data['content'] = json_encode($content);

            array_merge(['status' => config('database.diagram_status.without_diagram')], $data);

            $this->designDiagramRepository
                ->makeModel()
                ->updateOrCreate(
                    [
                        'workspace_id' => $data['workspace_id'],
                    ],
                    $data
                );
            
            $this->locationRepository->makeModel()
                ->where('workspace_id', $request->workspace_id)
                ->whereNotIn('id', $ids)
                ->delete();
                
            DB::commit();

            return response()->json(__('Success'), 200);
        } catch (Exception $exception) {
            DB::rollback();

            return response()->json($exception, 422);
        }
    }

    public function designDiagramImage(Request $request, $id)
    {
        $diagramDetail = $this->designDiagramRepository->where('workspace_id', $id)->first();
        $workspace = $this->workspace->findOrFail($id);

        return view('test.workspace.diagram_image', compact('diagramDetail', 'workspace'));
    }

    public function showDiagram(Request $request, $id)
    {
        $workspace = $this->workspace->findOrFail($id);
        $diagram = $this->designDiagramRepository->where('workspace_id', $id)->first();

        if ($diagram->diagramContent) {
            return view('diagrams.diagram', compact('workspace', 'diagram'));
        }

        return view('diagrams.design_diagram', compact('workspace'));
    }
}
