<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('status_id')->unsigned();
            $table->integer('menu_id')->unsigned();
            $table->integer('category_id')->unsigned()->nullable();
            $table->integer('parent_id')->unsigned()->nullable();
            $table->integer('cost')->nullable();
            $table->integer('price')->nullable();
            $table->boolean('gluten_free');
            $table->boolean('vegetarian');
            $table->boolean('vegan');
            $table->integer('order')->unsigned();
            $table->text('notes')->nullable();
            $table->integer('author_id')->unsigned();
            $table->timestamp('publish_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menu_items');
    }
}
