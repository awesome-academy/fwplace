<?php

namespace App\Http\Controllers\Api;

use App\Batch;
use Illuminate\Http\Request;
use App\Repositories\BatchRepository;
use App\Http\Resources\BatchResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

class BatchApi extends Controller
{
    private $batchRepository;

    public function __construct(BatchRepository $batchRepository)
    {
        $this->batchRepository = $batchRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BatchResource::collection($this->batchRepository->getAll());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->batchRepository->find($id);
    }
}
