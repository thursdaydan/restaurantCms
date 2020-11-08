<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
   public function up(): void
   {
       Schema::create('pages', static function (Blueprint $table) {
           $table->id();
           $table->string('');
           $table->timestamps();
       });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
   public function down(): void
   {
       Schema::drop('pages');
   }
}
