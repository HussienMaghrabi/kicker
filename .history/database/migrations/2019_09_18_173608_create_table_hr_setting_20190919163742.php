<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableHrSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hr_setting', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('work_info_id')->unsigned();
            $table->integer('annual_vacation')->nullable();
            $table->timestamps();
            $table->foreign('work_info_id')->references('id')->on('work_information');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hr_setting');
    }
}
