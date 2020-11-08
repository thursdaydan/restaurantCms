<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::table('menus', static function (Blueprint $table) {
            $table->integer('menu_layout_id')->default(1)->after('type_id');
            $table->integer('currency_id')->default(1)->after('menu_layout_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table('menus', static function (Blueprint $table) {
            $table->dropColumn('menu_layout_id', 'currency_id');
        });
    }
}
