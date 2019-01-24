<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Batch;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class ReportRepository extends EloquentRepository
{
    public function model()
    {
        return \App\Models\Report::class;
    }

    public function getReports($search)
    {
        $this->makeModel();

        return $this->model->join('users', 'reports.id', 'users.id')
                    ->where('name', 'Like', '%' . $search . '%')
                    ->orderBy('name')
                    ->select('reports.*', 'users.name', 'users.email', 'users.school')
                    ->paginate(config('paginate'));
    }

    public function getReportsBySubjectID($subjectID, $userID)
    {
        $this->makeModel();

        $reports = $this->model
            ->where('user_id', $userID)
            ->where('subject_id', $subjectID)
            ->orderBy('day', 'asc')
            ->get();
        
        foreach ($reports as $report) {
            $report->reviews = DB::table('reviews')
            ->select(
                'reviews.*',
                'users.name',
                DB::raw('COALESCE(reviews.content, \'\') as review')
            )
            ->where('reviews.report_id', $report->id)
            ->join('users', 'users.id', 'reviews.user_id')
            ->get();
        }

        return $reports;
    }

    public function getReportsBySubject($search)
    {
        $this->makeModel();

        return $this->model->join('subjects', 'reports.subject_id', 'subjects.id')
                    ->where('reports.subject_id', $search)
                    ->orderBy('reports.id')
                    ->select('reports.*', 'subjects.name')
                    ->get();
    }

    public function getReportsGroupBySubject($userID)
    {
        $user = User::findOrFail($userID);
        $batch = Batch::findOrFail($user->batch_id);
        $subjects = $batch->subjects;
        $result = [];
        foreach ($subjects as $subject) {
            $this->makeModel();
            $data = $this->getReportsBySubjectID($subject->id, $userID);
            $result = array_merge($result, [$data]);
        }

        return $result;
    }
}
