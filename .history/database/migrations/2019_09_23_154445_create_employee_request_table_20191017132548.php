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
            $table->integer('request_status_id')->unsignedInteger();
            $table->integer('request_type_id')->unsignedInteger();
            $table->text('note');
            $table->date('date_from');
            $table->date('date_too');
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
