<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PositionFormRequest;
use App\Repositories\PositionRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    public $positionRepository;
    public $userRepository;

    public function __construct(PositionRepository $positionRepository, UserRepository $userRepository)
    {
        $this->positionRepository = $positionRepository;
        $this->userRepository = $userRepository;

        $this->middleware('checkLogin');
        $this->middleware('permission:view-positions')->only('index');
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
        $positions = $this->positionRepository->get();

        return view('admin.positions.index', compact('positions'));
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
    public function store(PositionFormRequest $request)
    {
        $data = $request->all();
        if (!$request->has('allow_register')) {
            $data['allow_register'] = config('site.disallow_register');
        }
        $this->positionRepository->create($data);
        Alert::success(trans('Add new Position'), trans('Successfully!!!'));

        return redirect('admin/positions');
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
        $position = $this->positionRepository->findOrFail($id);

        return view('admin.positions.edit', compact('position'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PositionFormRequest $request, $id)
    {
        $data = $request->all();
        if (!$request->has('allow_register')) {
            $data['allow_register'] = config('site.disallow_register');
        }
        $this->positionRepository->update($data, $id);
        Alert::success(trans('Edit Position'), trans('Successfully!!!'));

        return redirect('admin/positions');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = $this->userRepository->where('position_id', '=', $id)->count();
        if ($count > 0) {
            Alert::error(trans('Failed!!!'), trans('Can not delete the Position having User'));
        } else {
            $this->positionRepository->delete($id);
            Alert::success(trans('Successfully!!!'), trans('Delete Position'));
        }

        return redirect('admin/positions');
    }
}
