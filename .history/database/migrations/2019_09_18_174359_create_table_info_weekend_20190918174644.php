<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableInfoWeekend extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_weekend', function (Blueprint $table) {
            $table->increments('id');
            $table->foreign('weekend_id')->references('id')->on('weekends');
            $table->foreign('work_info_id')->references('id')->on('work_information');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_weekend');
    }
}
