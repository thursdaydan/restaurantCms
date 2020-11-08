<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         $this->call([
             CurrencySeeder::class,
             MenuLayoutsSeeder::class,
             // MenuStatusesSeeder::class,
             // MenuTypesSeeder::class,
             // UserSeeder::class,
         ]);
    }
}
