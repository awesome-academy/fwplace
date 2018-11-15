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
            'name' => 'php-trainer',
            'display_name' => 'PHP trainer',
        ]);

        Role::create([
            'name' => 'ruby-trainer',
            'display_name' => 'Ruby trainer',
        ]);

        Role::create([
            'name' => 'ios-trainer',
            'display_name' => 'IOS trainer',
        ]);

        Role::create([
            'name' => 'android-trainer',
            'display_name' => 'Android trainer',
        ]);

        Role::create([
            'name' => 'qa-trainer',
            'display_name' => 'QA trainer',
        ]);

        Role::create([
            'name' => 'design-trainer',
            'display_name' => 'Design trainer',
        ]);

        Role::create([
            'name' => 'trainee',
            'display_name' => 'Trainee',
        ]);
    }
}
