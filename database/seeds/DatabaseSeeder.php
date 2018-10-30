<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTableSeeder::class);
        $this->call(PositionSeeder::class);
        $this->call(WorkspaceTableSeeder::class);
        $this->call(LocationTableSeeder::class);
        $this->call(ProgramSeeder::class);
        $this->call(WorkingScheduleTableSeeder::class);
    }
}
