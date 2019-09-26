<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttendanceReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendance_report', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('attendance_id')->unsigned();
            $table->integer('data_status')->unsigned();
            $table->enum('loc',['in','out']);
            $table->timestamps();
            $table->foreign('attendance_id')->references('id')->on('attendance');
            $table->foreign('data_status')->references('id')->on('attendance_date_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendance_report');
    }
}
