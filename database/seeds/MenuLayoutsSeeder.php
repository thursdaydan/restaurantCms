<?php

use Illuminate\Database\Seeder;

class MenuLayoutsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = now();

        DB::table('menu_layouts')->insert([
            ['name' => 'single',       'class' => 'col-12',          'created_at' => $now, 'updated_at' => $now],
            ['name' => '2 column',     'class' => 'col-12 col-md-6', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'multi-column', 'class' => 'col',             'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
