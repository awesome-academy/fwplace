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
            'program_id' => 0,
            'position_id' => 1,
            'workspace_id' => 1,
            'role' => 2,
            'lang' => 1,
            'status' => 1,
        ]);

        User::create([
            'name' => 'Trainer PHP',
            'email' => 'trainer.php@framgia.com',
            'password' => bcrypt('framgia'),
            'program_id' => 1,
            'position_id' => 1,
            'workspace_id' => 1,
            'role' => 1,
            'lang' => 1,
            'status' => 1,
        ]);

        User::create([
            'name' => 'Trainer Ruby',
            'email' => 'trainer.ruby@framgia.com',
            'password' => bcrypt('framgia'),
            'program_id' => 2,
            'position_id' => 1,
            'workspace_id' => 2,
            'role' => 1,
            'lang' => 1,
            'status' => 1,
        ]);

        User::create([
            'name' => 'Trainee PHP',
            'email' => 'trainee.php@framgia.com',
            'password' => bcrypt('framgia'),
            'program_id' => 1,
            'position_id' => 1,
            'workspace_id' => 1,
            'role' => 0,
            'lang' => 1,
            'status' => 1,
        ]);

        User::create([
            'name' => 'Trainee Ruby',
            'email' => 'trainee.ruby@framgia.com',
            'password' => bcrypt('framgia'),
            'program_id' => 2,
            'position_id' => 1,
            'workspace_id' => 2,
            'role' => 0,
            'lang' => 1,
            'status' => 1,
        ]);
    }
}
