<?php

namespace App\Repositories\Subject;

use App\Models\User;
use App\Models\Subject;
use App\Repositories\EloquentRepository;
use App\Repositories\Subject\SubjectRepositoryInterface;

class SubjectEloquentRepository extends EloquentRepository implements SubjectRepositoryInterface
{
    public function model()
    {
        return Subject::class;
    }

    public function getNameSubject()
    {
        return $this->model->select(['name', 'day', 'created_at', 'id'])->get();
    }

    public function getUserSubject($id)
    {
        $user = User::findOrFail($id);

        return $this->model->select(['subjects.*'])
            ->join('batch_subject', 'subjects.id', 'batch_subject.subject_id')
            ->where('batch_subject.batch_id', $user->batch_id)
            ->orderBy('subjects.id')
            ->get();
    }
}
