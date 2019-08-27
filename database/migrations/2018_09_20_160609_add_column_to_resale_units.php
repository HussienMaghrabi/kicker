<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToResaleUnits extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resale_units', function($table) {
            $table->unsignedInteger('maintenance')->nullable();
            $table->unsignedInteger('bua')->nullable();
            $table->unsignedInteger('transfer')->nullable();
            $table->unsignedInteger('villa')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resale_units', function($table) {
            $table->dropColumn('maintenance');
            $table->dropColumn('bua');
            $table->dropColumn('transfer');
            $table->dropColumn('villa');
        });
    }
}
