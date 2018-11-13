<?php

use Illuminate\Database\Seeder;

class DesignDiagramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('design_diagram')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
