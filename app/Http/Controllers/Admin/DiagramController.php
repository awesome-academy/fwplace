<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\LocationRepository;
use App\Repositories\SeatRepository;
use App\Repositories\WorkspaceRepository;
use App\Repositories\ProgramInterface;
use App\Repositories\UserRepository;
use App\Repositories\PositionRepository;
use Illuminate\Http\Request;

class DiagramController extends Controller
{
    protected $userRepository;
    protected $programRepository;
    protected $positionRepository;
    protected $locationRepository;

    public function __construct(
        LocationRepository $locationRepository,
        WorkspaceRepository $workspaceRepository,
        SeatRepository $seatRepository,
        UserRepository $userRepository,
        ProgramInterface $programRepository,
        PositionRepository $positionRepository
    ) {
        $this->locationRepository = $locationRepository;
        $this->workspace = $workspaceRepository;
        $this->seat = $seatRepository;
        $this->userRepository = $userRepository;
        $this->programRepository = $programRepository;
        $this->positionRepository = $positionRepository;
    }

    public function typeWorkspaceInformation()
    {
        return view('test.workspace.create');
    }

    public function saveWorkspace(Request $request)
    {
        $workspace = $this->workspace->create([
            'name' => $request->name,
            'total_seat' => $request->total_seat,
            'seat_per_row' => $request->seat_per_row,
            'image' => '',
        ]);

        return redirect()->route('generate', ['id' => $workspace->id]);
    }

    public function generateDiagram(Request $request, $idWorkspace)
    {
        $workspace = $this->workspace->findOrFail($idWorkspace);
        $totalSeat = $workspace->total_seat;
        $seatPerRow = $workspace->seat_per_row;
        $remainderSeat = $totalSeat % $seatPerRow; // Lấy số ghế dư ra

        if ($remainderSeat > 0) {
            $totalRow = floor($totalSeat / $seatPerRow) + 1; // Lấy số hàng, nếu có dư thì +1 hàng để lưu số dư
        } else {
            $totalRow = floor($totalSeat / $seatPerRow);
        }
        $alphabet = range('A', 'Z'); // Tạo ra bảng chữ cái để đặt tên cho cột
        $columnName = $alphabet;
        if ($seatPerRow > count($alphabet)) {
            // Nếu như số ghế/hàng > bảng chữ cái thì sẽ kết hợp thêm 1 bảng chữ cái nữa: AA, AB, AC,...
            foreach ($alphabet as $char) {
                foreach ($alphabet as $additionalChar) {
                    $columnName[] = $char . $additionalChar;
                }
            }
        }

        $columnList = array_slice($columnName, 0, $seatPerRow); // Lấy danh sách tên các hàng
        $rowList = range(1, $totalRow); // Lấy danh sách tên các cột
        $renderSeat = [];
        $counting = 0; // Đếm số ghế được tạo ra
        foreach ($rowList as $key => $row) {
            foreach ($columnList as $column) {
                $counting++;
                if ($counting <= $totalSeat) {
                    // Chưa max thì sẽ thêm
                    $renderSeat[$row][] = $column . $row;
                } else {
                    // Nếu max thì thêm để tạo đủ ghế
                    $renderSeat[$row][] = null;
                }
            }
        }
        $locations = $workspace->locations;
        $colorLocation = [];
        foreach ($locations as $key => $location) {
            foreach ($location->seats as $id => $seat) {
                $colorLocation[$key][$id]['location'] = $location->name;
                $colorLocation[$key][$id]['seat_id'] = $seat->id;
                if ($seat->user != null) {
                    $colorLocation[$key][$id]['user_name'] = $seat->user->name;
                } else {
                    $colorLocation[$key][$id]['user_name'] = $seat->name;
                }
                $colorLocation[$key][$id]['name'] = $seat->name;
                $colorLocation[$key][$id]['color'] = $location->color;
                $colorLocation[$key][$id]['workspace_id'] = $location->workspace_id;
            }
        }
        $colorLocation = json_encode($colorLocation);
        $listProgram = $this->programRepository->listProgramArray();
        $listPosition = $this->positionRepository->listpositionArray();
        $listUser = $this->userRepository->getList('program_id', 1)->pluck('name', 'id');

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
        $location = $this->locationRepository->create([
        'name' => $request->name,
        'workspace_id' => $id,
        'color' => $request->color,
        ]);

        foreach ($seats as $value) {
            $this->seat->create([
            'name' => $value,
            'location_id' => $location->id,
            ]);
        }

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

        return view('test.workspace.index', compact('workspaces'));
    }

    public function detail($id)
    {
        $workspace = $this->workspace->findOrFail($id);
        $totalSeat = $workspace->total_seat;
        $seatPerRow = $workspace->seat_per_row;
        $remainderSeat = $totalSeat % $seatPerRow; // Lấy số ghế dư ra

        if ($remainderSeat > 0) {
            $totalRow = floor($totalSeat / $seatPerRow) + 1; // Lấy số hàng, nếu có dư thì +1 hàng để lưu số dư
        } else {
            $totalRow = floor($totalSeat / $seatPerRow);
        }

        $alphabet = range('A', 'Z'); // Tạo ra bảng chữ cái để đặt tên cho cột
        $columnName = $alphabet;
        if ($seatPerRow > count($alphabet)) {
            // Nếu như số ghế/hàng > bảng chữ cái thì sẽ kết hợp thêm 1 bảng chữ cái nữa: AA, AB, AC,...
            foreach ($alphabet as $char) {
                foreach ($alphabet as $additionalChar) {
                    $columnName[] = $char . $additionalChar;
                }
            }
        }

        $columnList = array_slice($columnName, 0, $seatPerRow); // Lấy danh sách tên các hàng
        $rowList = range(1, $totalRow); // Lấy danh sách tên các cột
        $renderSeat = [];
        $counting = 0; // Đếm số ghế được tạo ra
        foreach ($rowList as $key => $row) {
            foreach ($columnList as $column) {
                $counting++;
                if ($counting <= $totalSeat) {
                    // Chưa max thì sẽ thêm
                    $renderSeat[$row][] = $column . $row;
                } else {
                    // Nếu max thì thêm để tạo đủ ghế
                    $renderSeat[$row][] = null;
                }
            }
        }

        $locations = $workspace->locations;
        $colorLocation = [];
        foreach ($locations as $key => $location) {
            foreach ($location->seats as $id => $seat) {
                $colorLocation[$key][$id]['location'] = $location->name;
                $colorLocation[$key][$id]['name'] = $seat->name;
                $colorLocation[$key][$id]['color'] = $location->color;
            }
        }
        $colorLocation = json_encode($colorLocation);

        return view('test.workspace.detail', compact('workspace', 'renderSeat', 'colorLocation', 'locations'));
    }
}
