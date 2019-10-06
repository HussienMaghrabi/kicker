<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_request', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->integer('request_status_id');
            $table->integer('request_type_id');
            $table->integer('note');
            $table->timestamps();
            // $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('request_status_id')->references('id')->on('request_status');
            $table->foreign('request_type_id')->references('id')->on('request_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_request');
    }
}
