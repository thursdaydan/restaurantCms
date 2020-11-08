<?php

use Illuminate\Database\Seeder;

class MenuTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = now();

        DB::table('menu_types')->insert([
            ['name' => 'Breakfast', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Lunch',     'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Main',      'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Drinks',    'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
