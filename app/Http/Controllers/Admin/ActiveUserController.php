<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use App\Batch;
use DB;

class ActiveUserController extends Controller
{
    protected $user;

    public function __construct(UserRepository $user)
    {
        $this->user = $user;
    }

    public function activeUser(Request $request, $id)
    {
        $user = $this->user->find($id);
        $user->status = config('site.active');
        $user->save();

        return response()->json(['message' => trans('Active User successfully')]);
    }
}
