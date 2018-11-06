<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('users')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name' => 'Admin',
            'email' => 'admin@framgia.com',
            'password' => bcrypt('framgia'),
            'program_id' => 1,
            'position_id' => 1,
            'workspace_id' => 1,
            'role' => 2,
            'lang' => 1,
            'status' => 1,
        ]);

        User::create([
            'name' => 'Trainer',
            'email' => 'trainer@framgia.com',
            'password' => bcrypt('framgia'),
            'program_id' => 1,
            'position_id' => 1,
            'workspace_id' => 1,
            'role' => 1,
            'lang' => 1,
            'status' => 1,
        ]);

        User::create([
            'name' => 'Trainee',
            'email' => 'trainee@framgia.com',
            'password' => bcrypt('framgia'),
            'program_id' => 1,
            'position_id' => 1,
            'workspace_id' => 1,
            'role' => 0,
            'lang' => 1,
            'status' => 1,
        ]);
    }
}
