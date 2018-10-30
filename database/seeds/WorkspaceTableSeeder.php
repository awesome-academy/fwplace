<?php

use Illuminate\Database\Seeder;

class WorkspaceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workspaces = [
            [
                'name' => 'Handico',
                'image' => '1.jpg',
                'total_seat' => 150,
                'seat_per_row' => 10,
            ],
            [
                'name' => 'KeangNam',
                'image' => '2.jpg',
                'total_seat' => 150,
                'seat_per_row' => 9,
            ],
            [
                'name' => 'Lab',
                'image' => '3.jpg',
                'total_seat' => 150,
                'seat_per_row' => 8,
            ],
        ];

        DB::table('workspaces')->insert($workspaces);
    }
}
