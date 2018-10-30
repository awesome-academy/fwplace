<?php

use Illuminate\Database\Seeder;

class LocationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workspaces = DB::table('workspaces')->get();
        if ($workspaces && count($workspaces) > 0) {
            $faker = \Faker\Factory::create();
            foreach (range(1, 10) as $value) {
                DB::table('locations')->insert([
                    'name' => $faker->state,
                    'workspace_id' => $workspaces->random()->id,
                    'color' => substr(md5(rand()), 0, 6),
                ]);
            }
        }
    }
}
