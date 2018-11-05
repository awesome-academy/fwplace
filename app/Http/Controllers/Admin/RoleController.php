<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Http\Controllers\Controller;
use App\Repositories\RoleRepository;
use App\Repositories\PermissionRepository;
use Validator;
use Entrust;
use DB;

class RoleController extends Controller
{
    public $roleRepository;
    public $permissionRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $rules = [
                'name' => 'required|string|unique:roles',
                'display_name' => 'required|string|unique:roles',
            ];

            $messages = [
                'name.required' => __('Role') . __('Required'),
                'name.string' => __('Role') . __('String'),
                'name.unique' => __('Role') . __('Unique'),
                'display_name.required' => __('Display name') . __('Required'),
                'display_name.string' => __('Display name') . __('String'),
                'display_name.unique' => __('Display name') . __('Unique'),
            ];

            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'valid',
                    'message' => $validator->errors(),
                ]);
            } else {
                $this->roleRepository->create($data);

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Success !',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Fail !',
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
        return view('admin.roles.show', [
            'role_id' => $id,
        ]);
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
            $role = $this->roleRepository->findOrFail($id);

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Success !',
                'role' => $role,
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => 'Fail !',
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
            $rules = [
                'name' => 'required|string',
                'display_name' => 'required|string',
            ];

            $messages = [
                'name.required' => __('Role') . __('Required'),
                'name.string' => __('Role') . __('String'),
                'display_name.required' => __('Display name') . __('Required'),
                'display_name.string' => __('Display name') . __('String'),
            ];

            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return response()->json([
                    'error' => 'valid',
                    'message' => $validator->errors(),
                ]);
            } else {
                $this->roleRepository->update($data, $id);

                DB::commit();

                return response()->json([
                    'error' => false,
                    'message' => 'Success !',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => true,
                'message' => 'Fail !',
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
            DB::table('roles')->where('id', $id)->delete();

            DB::commit();

            return response()->json([
                'error' => false,
                'message' => 'Success !',
            ]);
        } catch (Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => true,
                'message' => 'Fail !',
            ]);
        }
    }

    /**
     * [getRoles : Lấy ra danh sách vai trò]
     * @return [type] [description]
     */
    public function getRoles()
    {
        $roles = $this->roleRepository->orderBy('id', 'desc')->get();

        return Datatables::of($roles)
            ->addIndexColumn()

            ->editColumn('created_at', function ($role) {
                $time = $role->created_at;

                $timeNumb = strtotime($time);

                return date('H:i | d-m-Y', $timeNumb);
            })

            ->addColumn('action', function ($role) {
                return $role->id;
            })

        ->make(true);
    }

    /**
     * [getPermissionRole : Lấy những quyền hạn thuộc vai trò đó]
     * @param  [type] $role_id [description]
     * @return [type]          [description]
     */
    public function getPermissionRole($roleId)
    {
        $role = $this->roleRepository->findOrFail($roleId);

        $permissions = $this->permissionRepository->orderBy('id', 'desc')->get();

        return Datatables::of($permissions)
            ->addIndexColumn()

            ->editColumn('created_at', function ($permission) {
                $time = $permission->created_at;

                $timeNumb = strtotime($time);

                return date('H:i | d-m-Y', $timeNumb);
            })

            ->addColumn('action', function ($permission) use ($role) {
                $flag = DB::table('permission_role')
                        ->where('role_id', $role->id)
                        ->where('permission_id', $permission->id)
                        ->where('deleted_at', null)
                        ->count();

                return [
                    'flag' => $flag,
                    'roleId' => $role->id,
                    'permissionId' => $permission->id,
                ];
            })

        ->make(true);
    }

    /**
     * [updatePermissionRole : Cập nhật quyền hạn cho vai trò]
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function updatePermissionRole(Request $request)
    {
        if ($request->checked == 1) {
            DB::table('permission_role')
                ->where('role_id', $request->role_id)
                ->where('permission_id', $request->permission_id)
                ->delete();

            return response()->json([
                'error' => false,
                'message' => 'deleted',
            ], 200);
        } else {
            DB::table('permission_role')->insert([
                'role_id' => $request->role_id,
                'permission_id' => $request->permission_id,
                'created_at' => date('Y-m-d H:m:s', time()),
            ]);

            return response()->json([
                'error' => false,
                'message' => 'added',
            ], 200);
        }
    }
}
