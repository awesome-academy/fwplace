<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use App\Repositories\SeatRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\ProgramInterface;
use App\Repositories\UserRepository;
use App\Repositories\PositionRepository;
use App\Repositories\DesignDiagramRepository;
use APP\Repositories\WorkingScheduleRepository;
use Illuminate\Http\Request;
use App\Http\Requests\DesignDiagramRequests;
use DB;
use Validator;
use Entrust;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Traits\Generating;

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
        DesignDiagramRepository $designDiagramRepository
    ) {
        $this->locationRepository = $locationRepository;
        $this->workspace = $workspaceRepository;
        $this->seat = $seatRepository;
        $this->userRepository = $userRepository;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
        $this->designDiagramRepository = $designDiagramRepository;
    }

    public function saveWorkspace(Request $request)
    {
        $data = $request->all();
        if ($request->image) {
            $request->image->store(config('site.workspace.image'));
            $data['image'] = $request->image->hashName();
        }
        $workspace = $this->workspace->create($data);

        return redirect()->route('generate', ['id' => $workspace->id]);
    }

    public function generateDiagram(Request $request, $idWorkspace)
    {
        $workspace = $this->workspace->findOrFail($idWorkspace);
        $renderSeat = $this->renderSeat($workspace);
        $locations = $workspace->locations;
        $colorLocation = $this->getColorLocation($locations);
        $listProgram = $this->programRepository->listProgramArray();
        $listPosition = $this->positionRepository->listpositionArray();

        if (Entrust::can(['php-manager']) &&
            Entrust::can(['ruby-manager']) &&
            Entrust::can(['ios-manager']) &&
            Entrust::can(['android-manager']) &&
            Entrust::can(['qa-manager']) &&
            Entrust::can(['design-manager'])
        ) {
            $listUser = $this->userRepository->pluck('name', 'id');
        } elseif (Entrust::can(['php-manager'])) {
            $listUser = $this->userRepository->getList('program_id', 1)->pluck('name', 'id');
        } elseif (Entrust::can(['ruby-manager'])) {
            $listUser = $this->userRepository->getList('program_id', 2)->pluck('name', 'id');
        } elseif (Entrust::can(['ios-manager'])) {
            $listUser = $this->userRepository->getList('program_id', 3)->pluck('name', 'id');
        } elseif (Entrust::can(['android-manager'])) {
            $listUser = $this->userRepository->getList('program_id', 4)->pluck('name', 'id');
        } elseif (Entrust::can(['qa-manager'])) {
            $listUser = $this->userRepository->getList('program_id', 5)->pluck('name', 'id');
        } elseif (Entrust::can(['design-manager'])) {
            $listUser = $this->userRepository->getList('program_id', 6)->pluck('name', 'id');
        }

        return view('test.workspace.generate', compact(
            'renderSeat',
            'idWorkspace',
            'colorLocation',
            'listProgram',
            'listPosition',
            'listUser'
        ));
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
                    'usable' => $request->has('usable') ? $request->usable : config('site.default.unusable'),
                ]);
            }
        });

        return redirect()->back();
    }

    public function saveAjaxLocation(Request $request)
    {
        $data = $this->locationRepository->create([
            'name' => $request->name,
            'workspace_id' => $request->id,
            'color' => $request->color,
        ]);

        $seats = $request->seat;
        foreach ($seats as $value) {
            $this->seat->create([
                'name' => $value,
                'location_id' => $data->id,
            ]);
        }

        return response()->json($data);
    }

    public function list()
    {
        $workspaces = $this->workspace->get();

        return view('test.workspace.index', [
            'workspaces' => $workspaces,
        ]);
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

    public function imageMap()
    {
        $workspaces = $this->workspace->get();

        return view('test.workspace.image_map', compact('workspaces'));
    }

    public function saveDesignDiagram(DesignDiagramRequests $request)
    {
        $data = $request->only('name', 'diagram', 'content');
        DB::beginTransaction();
        try {
            if ($request->diagram) {
                $request->diagram->store(config('site.diagram.image'));
                $data['diagram'] = $request->diagram->hashName();
            }
            $this->designDiagramRepository->create($data);
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
}
