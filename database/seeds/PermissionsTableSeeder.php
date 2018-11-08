<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        /*Positions*/
        Permission::create([
            'name' => 'view-positions',
            'display_name' => 'Position list',
        ]);

        Permission::create([
            'name' => 'add-positions',
            'display_name' => 'Add position',
        ]);

        Permission::create([
            'name' => 'detail-positions',
            'display_name' => 'Position detail',
        ]);

        Permission::create([
            'name' => 'edit-positions',
            'display_name' => 'Edit position',
        ]);

        Permission::create([
            'name' => 'delete-positions',
            'display_name' => 'Delete position',
        ]);
        /*---------*/

        /*Programs*/
        Permission::create([
            'name' => 'view-programs',
            'display_name' => 'Tech language list',
        ]);

        Permission::create([
            'name' => 'add-programs',
            'display_name' => 'Add tech language',
        ]);

        Permission::create([
            'name' => 'detail-programs',
            'display_name' => 'Tech language detail',
        ]);

        Permission::create([
            'name' => 'edit-programs',
            'display_name' => 'Edit tech language',
        ]);

        Permission::create([
            'name' => 'delete-programs',
            'display_name' => 'Delete tech language',
        ]);
        /*--------*/

        /*Users*/
        Permission::create([
            'name' => 'view-users',
            'display_name' => 'Employee list',
        ]);

        Permission::create([
            'name' => 'add-users',
            'display_name' => 'Add employee',
        ]);

        Permission::create([
            'name' => 'detail-users',
            'display_name' => 'Employee detail',
        ]);

        Permission::create([
            'name' => 'edit-users',
            'display_name' => 'Edit employee',
        ]);

        Permission::create([
            'name' => 'delete-users',
            'display_name' => 'Delete employee',
        ]);

        Permission::create([
            'name' => 'role-users',
            'display_name' => 'Employee role',
        ]);
        /*----*/

        /*Seat Statistical*/
        Permission::create([
            'name' => 'seat-statistical',
            'display_name' => 'Seat map statistic',
        ]);
        /*----------------*/

        /*Work Schedules*/
        Permission::create([
            'name' => 'work-schedules',
            'display_name' => 'Working calendar',
        ]);
        /*--------------*/

        /*Register Work Schedules*/
        Permission::create([
            'name' => 'register-work-schedules',
            'display_name' => 'Working time register',
        ]);
        /*--------------*/

        /*Workspaces*/
        Permission::create([
            'name' => 'view-workspaces',
            'display_name' => 'Workspace list',
        ]);

        Permission::create([
            'name' => 'add-workspaces',
            'display_name' => 'Add workspace',
        ]);

        Permission::create([
            'name' => 'detail-workspaces',
            'display_name' => 'Workspace detail',
        ]);

        Permission::create([
            'name' => 'edit-workspaces',
            'display_name' => 'Edit workspace',
        ]);

        Permission::create([
            'name' => 'delete-workspaces',
            'display_name' => 'Delete workspace',
        ]);

        Permission::create([
            'name' => 'add-location',
            'display_name' => 'Add location',
        ]);
        /*---------*/

        /*Roles*/
        Permission::create([
            'name' => 'view-roles',
            'display_name' => 'Role list',
        ]);

        Permission::create([
            'name' => 'add-roles',
            'display_name' => 'Add role',
        ]);

        Permission::create([
            'name' => 'permission-roles',
            'display_name' => 'Role permission',
        ]);

        Permission::create([
            'name' => 'edit-roles',
            'display_name' => 'Edit role',
        ]);

        Permission::create([
            'name' => 'delete-roles',
            'display_name' => 'Delete role',
        ]);
        /*-----*/

        /*Permissions*/
        Permission::create([
            'name' => 'view-permissions',
            'display_name' => 'Permission list',
        ]);
        /*-----------*/
    }
}
