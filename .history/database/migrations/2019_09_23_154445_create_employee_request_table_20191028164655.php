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
            $table->unsignedInteger('request_status_id');
            $table->unsignedInteger('request_type_id');
            $table->text('note');
            $table->string('days')->nullable();
            $table->date('date_from');
            $table->date('date_too');
            $table->timestamps();
            // $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('request_status_id')->references('id')->on('request_status')->onDelete('CASCADE');
            $table->foreign('request_type_id')->references('id')->on('request_type')->onDelete('CASCADE');
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
