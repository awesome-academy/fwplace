<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SpecialDay;
use App\Http\Requests\SpecialDayRequest;

class SpecialDayController extends Controller
{
    public function create()
    {
        return view('admin.special_day.create');
    }

    public function store(SpecialDayRequest $request)
    {
        $data = $request->all();
        $day = SpecialDay::create([
            'title' => $data['title'],
            'to' => $data['to'],
            'from' => $data['from'],
        ]);
        if (isset($request->compensation_from)) {
            $data['compensation_title'] = 'Compensation: from: ' . $request->from . ' to: ' . $request->to;
            SpecialDay::create([
                'title' => $data['compensation_title'],
                'to' => $data['compensation_to'],
                'from' => $data['compensation_from'],
                'is_compensation' => $day->id,
            ]);
        }

        return redirect()->back()->with('status', 'Create success');
    }
}
