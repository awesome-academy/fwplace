<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Batch;
use Carbon\Carbon;
use App\Repositories\UserRepository;
use App\Http\Resources\UserResource;

class TraineeApi extends Controller
{
    private $traineeRepository;

    public function __construct(UserRepository $traineeRepository)
    {
        $this->traineeRepository = $traineeRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return UserResource::collection($this->traineeRepository->getAllTrainee());
    }

    public function getTraineeByBatch(Request $request, $id)
    {
        return UserResource::collection($this->traineeRepository->getAllTrainee($id));
    }
}
