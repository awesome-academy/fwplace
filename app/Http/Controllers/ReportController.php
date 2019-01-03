<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Report;
use App\Models\Subject;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ReportResource;
use App\Repositories\ReportRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;

class ReportController extends Controller
{
    private $reportRepository;
    private $subjectRepository;

    public function __construct(
        ReportRepository $reportRepository,
        SubjectRepositoryInterface $subjectRepository
    ) {
        $this->reportRepository = $reportRepository;
        $this->subjectRepository = $subjectRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        $subjects = $this->subjectRepository->getUserSubject($user->id);
        foreach ($subjects as $subject) {
            $subject->reports = $this->reportRepository->getReportsBySubjectID($subject->id, $user->id);
        }

        return response()->json($subjects);
    }

    public function getReportsBySubject(Request $request, $search)
    {
        return response()->json(['data' => $this->reportRepository->getReportsBySubject($search)]);
    }

    public function getReportsGroupBySubject(Request $request, $id)
    {
        $users = User::where('batch_id', $id)->paginate(config('api.report_paginate'));
        foreach ($users as $user) {
            $user->reports = $this->reportRepository->getReportsGroupBySubject($user->id);
        }
        
        return response()->json($users);
    }

    public function getReportsByTrainee(Request $request, $id)
    {
        $subjects = $this->subjectRepository->getUserSubject($id);

        foreach ($subjects as $subject) {
            $subject->reports = $this->reportRepository->getReportsBySubjectID($subject->id, $id);
        }

        return response()->json($subjects);
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
    public function store(ReportRequest $request)
    {
        if ($request->id === null) {
            return $this->reportRepository->create(
                array_merge(
                    array_filter(
                        $request->only(
                            'content',
                            'link',
                            'test_link',
                            'lesson',
                            'status',
                            'subject_id',
                            'day'
                        )
                    ),
                    ['user_id' => Auth::user()->id]
                )
            );
        } else {
            $report = Report::findOrFail($request->id);

            $report->fill($request->except(['id', 'subject_id', 'day', 'user_id']))->save();

            return response()->json(['message' => config('api.success')]);
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
        return $this->reportRepository->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $report = Report::findOrFail($id);
        if (Auth::user()->cannot('update', $report)) {
            return response()->json(['message' => config('api.denied')], 403);
        }

        return $this->reportRepository->update($request->all(), $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
