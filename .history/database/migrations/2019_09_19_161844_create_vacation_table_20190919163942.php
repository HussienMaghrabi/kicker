<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('vacation_type_id')->unsigned();
            $table->string('reason');
            $table->string('vacation_payment_desire')->nullable();
            $table->string('feed_back')->nullable();
            $table->string('notes')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('approved_by');
            $table->integer('number_of_days');
            $table->enum('vacations_payment',['paid','non paid']);
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('vacation_type_id')->references('id')->on('vacation_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacations');
    }
}
