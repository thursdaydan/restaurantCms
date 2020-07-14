<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('menus', static function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('status_id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('order')->unsigned();
            $table->text('header_text')->nullable();
            $table->text('footer_text')->nullable();
            $table->timestamp('publish_at')->nullable();
            $table->integer('author_id')->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::drop('menus');
    }
}
