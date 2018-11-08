<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
        ]);

        Role::create([
            'name' => 'trainer',
            'display_name' => 'Trainer',
        ]);

        Role::create([
            'name' => 'trainee',
            'display_name' => 'Trainee',
        ]);
    }
}
