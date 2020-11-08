<?php

use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $now = now();

        DB::table('currencies')->insert([
            ['name' => 'British pound',        'symbol' => '£', 'html_entity' => '&pound;', 'iso_code' => 'GBP', 'territory' => 'United Kingdom', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Euro',                 'symbol' => '€', 'html_entity' => '&euro;',  'iso_code' => 'EUR', 'territory' => 'European Union', 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'United States dollar', 'symbol' => '$', 'html_entity' => '$',       'iso_code' => 'USD', 'territory' => 'United States',  'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
