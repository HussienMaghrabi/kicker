<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('en_first_name');
            $table->string('en_middle_name')->nullable();
            $table->string('en_last_name');
            $table->string('ar_first_name')->nullable();
            $table->string('ar_middle_name')->nullable();
            $table->string('ar_last_name')->nullable();
            $table->string('phone');
            $table->string('email');
            $table->string('personal_mail');
            $table->string('company_mail');
            $table->integer('job_category_id');
            $table->integer('job_title_id');
            $table->integer('industry_id');
            $table->date('birth_date');
            $table->text('address');
            $table->text('job_history');
            $table->integer('national_id')->nullable();
            $table->integer('salary')->nullable();
            $table->integer('photo_id')->nullable();
            $table->integer('is_hr');
            $table->double('day_value',8,2);
            $table->integer('finger_print_id');
            $table->integer('annual_vacations');
            $table->integer('unscheduled_vacation');
            $table->integer('requested_vacation');
            $table->enum('gender',['male','female']);
            $table->enum('marital_status',['single','engaged','married','divorced']);
            $table->enum('military_status',['fullfilled','postponed','exempted','femal']);
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
        Schema::dropIfExists('employees');
    }
}
