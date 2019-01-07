<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserRepository extends EloquentRepository
{

    public function model()
    {
        return User::class;
    }

    public function create(array $attr)
    {
        $user = $this->model->create($attr);
        $user->roles()->sync($attr['role']);
    }

    public function getListName($name)
    {
        return $this->model->where('name', 'like', '%' . $name . '%');
    }

    public function getList($field, $fieldId)
    {
        return $this->model->where($field, '=', $fieldId);
    }

    public function getDataUserTimesheet($userId, $dates)
    {
        $user = $this->model->findOrFail($userId);
        $fulltime = $this->getByShift(
            $user,
            $dates,
            '-' . __('Fulltime'),
            config('site.shift.all'),
            config('site.calendar.fulltime-color')
        );
        $morning = $this->getByShift(
            $user,
            $dates,
            '-' . __('Morning'),
            config('site.shift.morning')
        );
        $afternoon = $this->getByShift(
            $user,
            $dates,
            '-' . __('Afternoon'),
            config('site.shift.afternoon'),
            config('site.calendar.afternoon-color')
        );
        $off = $this->getByShift(
            $user,
            $dates,
            '-' . __('Off'),
            config('site.shift.off'),
            config('site.calendar.off-color')
        );
        $locations = $this->getLocationByDay($user, $dates);

        return array_merge($fulltime, $morning, $afternoon, $off, $locations);
    }

    public function getByShift($user, $dates, $trans, $shift, $color = null)
    {
        $color = $color ?? config('site.calendar.default-color');

        return $user->workSchedules()
            ->select(DB::raw('date as start, "' . $trans . '" as title, ' . $color . 'as className'))
            ->whereBetween('date', [$dates['start'], $dates['end']])
            ->where('shift', $shift)
            ->get()->toArray();
    }

    public function getLocationByDay($user, $dates, $color = null)
    {
        $color = $color ?? config('site.calendar.default-color');

        $data = $user->workSchedules()
            ->select(DB::raw('date as start, location_id, shift'))
            ->whereBetween('date', [$dates['start'], $dates['end']])
            ->get();

        if ($data->count() <= 0) {
            return [];
        }
        $locationByDay = [];
        foreach ($data as $item) {
            $location = DB::table('locations')->find($item->location_id);
            if ($item->shift != 0 && $item->location_id != 0 && $location) {
                $locationByDay[] = [
                    'start' => $item->start,
                    'title' => __('Location') . ': ' . $location->name,
                    'className' => $color,
                ];
            }
        }

        return $locationByDay;
    }

    public function getListTrainee($id)
    {
        $trainee = $this->model->where('trainer_id', '=', $id)
            ->orderBy('created_at', 'DESC')
            ->paginate(config('site.paginate_user'));

        return $trainee;
    }

    public function getSelectTrainer($programId)
    {
        return $this->model->where('role', '=', config('site.permission.trainer'))
            ->where('program_id', '=', $programId)->pluck('name', 'id')->toArray();
    }
}
