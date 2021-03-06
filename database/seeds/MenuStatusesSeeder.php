<?php

use Illuminate\Database\Seeder;

class MenuStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = now();

        DB::table('menu_statuses')->insert([
            [
                'name'              => 'In Progress',
                'text_colour'       => '#fafafa',
                'background_colour' => '#616161',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'In Review',
                'text_colour'       => '#fffde7',
                'background_colour' => '#fbc02d',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Approved',
                'text_colour'       => '#e3f2fd',
                'background_colour' => '#1976d2',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'In Publish Queue',
                'text_colour'       => '#f3e5f5',
                'background_colour' => '#7b1fa2',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'name'              => 'Hidden',
                'text_colour'       => '#ffebee',
                'background_colour' => '#d32f2f',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ]);
    }
}
