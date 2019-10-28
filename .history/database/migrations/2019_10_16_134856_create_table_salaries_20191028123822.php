<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableSalaries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salaries', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('employee_id');
            $table->double('basic')->nullable();
            $table->double('gross')->nullable();
            $table->double('net')->nullable();
            $table->double('full_salary')->nullable();
            $table->double('hour_value')->nullable();
            $table->double('worked_hours')->nullable();
            $table->double('salary_on_hours')->nullable();
            $table->date('date')->nullable();
            $table->date('start_day')->nullable();
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salaries');
    }
}
