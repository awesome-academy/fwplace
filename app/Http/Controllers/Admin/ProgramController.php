<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Repositories\ProgramRepository;
use App\Http\Requests\ProgramRequest;
use App\Models\Program;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use Entrust;
use DB;

class ProgramController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $programRepository;

    public function __construct(ProgramRepository $programRepository)
    {
        $this->programRepository = $programRepository;

        $this->middleware('checkLogin');
        $this->middleware('permission:view-programs')->only(['index', 'getPrograms']);
        $this->middleware('permission:add-programs')->only(['create', 'store']);
        $this->middleware('permission:detail-programs')->only('show');
        $this->middleware('permission:edit-programs')->only(['edit', 'update']);
        $this->middleware('permission:delete-programs')->only('destroy');
    }

    public function index()
    {
        return view('admin.programs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.programs.add');
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
            $validator = ProgramRequest::rulesStore($request);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'valid',
                    'message' => $validator->errors(),
                ]);
            } else {
                $this->programRepository->create($data);

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
            $program = $this->programRepository->findOrFail($id);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => __('Success'),
                'program' => $program,
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
            $validator = ProgramRequest::rulesUpdate($request, $id);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'valid',
                    'message' => $validator->errors(),
                ]);
            } else {
                $this->programRepository->update($data, $id);

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
            DB::table('programs')->where('id', $id)->delete();

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
     * [getPrograms : Lấy ra danh sách các ngôn ngữ]
     * @return [type] [description]
     */
    public function getPrograms()
    {
        $programs = $this->programRepository->orderBy('id', 'desc')->get();

        return Datatables::of($programs)
            ->addIndexColumn()

            ->addColumn('action', function ($program) {
                if (Entrust::can(['edit-programs'])) {
                    $editPrograms = 1;
                } else {
                    $editPrograms = 0;
                }

                if (Entrust::can(['delete-programs'])) {
                    $deletePrograms = 1;
                } else {
                    $deletePrograms = 0;
                }

                return [
                    'editPrograms' => $editPrograms,
                    'deletePrograms' => $deletePrograms,
                    'programId' => $program->id,
                ];
            })

        ->make(true);
    }
}
