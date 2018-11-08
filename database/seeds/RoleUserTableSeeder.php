<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;

class RoleUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('role_user')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $user = User::where('email', 'admin@framgia.com')->first();

        $role = Role::where('name', 'admin')->first();

        DB::table('role_user')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }
}
