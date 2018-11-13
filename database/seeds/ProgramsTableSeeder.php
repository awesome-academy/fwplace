<?php

use Illuminate\Database\Seeder;
use App\Models\Program;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('programs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Program::create([
            'name' => 'PHP',
        ]);

        Program::create([
            'name' => 'Ruby',
        ]);

        Program::create([
            'name' => 'IOS',
        ]);

        Program::create([
            'name' => 'Android',
        ]);

        Program::create([
            'name' => 'QA',
        ]);

        Program::create([
            'name' => 'Design',
        ]);
    }
}
