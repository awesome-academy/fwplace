<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionFormRequest;
use App\Repositories\PositionRepository;
use App\Repositories\UserRepository;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use Entrust;
use DB;

class PositionController extends Controller
{
    public $positionRepository;
    public $userRepository;

    public function __construct(PositionRepository $positionRepository, UserRepository $userRepository)
    {
        $this->positionRepository = $positionRepository;
        $this->userRepository = $userRepository;

        $this->middleware('checkLogin');
        $this->middleware('permission:view-positions')->only(['index', 'getPositions']);
        $this->middleware('permission:add-positions')->only(['create', 'store']);
        $this->middleware('permission:detail-positions')->only('show');
        $this->middleware('permission:edit-positions')->only(['edit', 'update']);
        $this->middleware('permission:delete-positions')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.positions.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.positions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();

        try {
            $validator = PositionFormRequest::rulesStore($request);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'valid',
                    'message' => $validator->errors(),
                ]);
            } else {
                if (!$request->has('allow_register')) {
                    $data['allow_register'] = config('site.disallow_register');
                }

                $this->positionRepository->create($data);

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => __('Success'),
                ]);
            }
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => __('Fail'),
            ]);
        }
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
        DB::beginTransaction();

        try {
            $position = $this->positionRepository->findOrFail($id);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => __('Success'),
                'position' => $position,
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => __('Fail'),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        DB::beginTransaction();

        try {
            $validator = PositionFormRequest::rulesUpdate($request, $id);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'valid',
                    'message' => $validator->errors(),
                ]);
            } else {
                if ($request->checked == 'true') {
                    $data['allow_register'] = 1;
                } else {
                    $data['allow_register'] = 0;
                }

                $this->positionRepository->update($data, $id);

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => __('Success'),
                ]);
            }
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => __('Fail'),
            ]);
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
        DB::beginTransaction();

        try {
            DB::table('positions')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => __('Success'),
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => __('Fail'),
            ]);
        }
    }

    /**
     * [getPositions : Lấy ra danh sách các chức danh]
     * @return [type] [description]
     */
    public function getPositions()
    {
        $positions = $this->positionRepository->orderBy('id', 'desc')->get();

        return Datatables::of($positions)
            ->addIndexColumn()

            ->editColumn('is_fulltime', function ($position) {
                if ($position->is_fulltime == 1) {
                    $isFulltime = 'Full-time';
                } else {
                    $isFulltime = 'Part-time';
                }

                return $isFulltime;
            })

            ->addColumn('action', function ($position) {
                if (Entrust::can(['edit-positions'])) {
                    $editPositions = 1;
                } else {
                    $editPositions = 0;
                }

                if (Entrust::can(['delete-positions'])) {
                    $deletePositions = 1;
                } else {
                    $deletePositions = 0;
                }

                return [
                    'editPositions' => $editPositions,
                    'deletePositions' => $deletePositions,
                    'positionId' => $position->id,
                ];
            })

        ->make(true);
    }
}
