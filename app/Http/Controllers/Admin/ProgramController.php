<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\ProgramRepository;
use App\Http\Requests\ProgramRequest;
use App\Models\Program;
use RealRashid\SweetAlert\Facades\Alert;

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
        $this->middleware('permission:view-programs')->only('index');
        $this->middleware('permission:add-programs')->only(['create', 'store']);
        $this->middleware('permission:detail-programs')->only('show');
        $this->middleware('permission:edit-programs')->only(['edit', 'update']);
        $this->middleware('permission:delete-programs')->only('destroy');
    }

    public function index()
    {
        $dataPrograms = $this->programRepository->model()::all();

        return view('admin.programs.index', compact('dataPrograms'));
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
    public function store(ProgramRequest $request)
    {
        $this->programRepository->create($request->all());

        Alert::success(trans('Created Program'), trans('Successfully!!!'));

        return redirect()->route('programs.index');
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
        $pro = $this->programRepository->findOrFail($id);

        return view('admin.programs.edit', compact('pro'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProgramRequest $request, $id)
    {
        $this->programRepository->update($request->all(), $id);

        Alert::success(trans('Edit Program'), trans('Successfully!!!'));

        return redirect()->route('programs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->programRepository->delete($id);

        Alert::success(trans('Delete Program'), trans('Successfully!!!'));

        return redirect()->route('programs.index');
    }
}
