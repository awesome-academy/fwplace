<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;
use App\Models\Location;

class WorkingScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::with('position')->get();
        foreach ($users as $user) {
            if ($user->position->is_fulltime == config('site.parttime')) {
                for ($i = 0 ; $i < 31; $i++) { 
                    $day = Carbon::now()->startOfMonth()->addDay($i);
                    if (!$day->isWeekend()) {
                        $user->workSchedules()->create([
                            'date' => $day->format('Y-m-d'),
                            'shift' => collect([1, 2, 3])->random(),
                            'location_id' => $user->workspace->locations->random()->id
                        ]);
                    }
                }
            }
        }
    }
}
