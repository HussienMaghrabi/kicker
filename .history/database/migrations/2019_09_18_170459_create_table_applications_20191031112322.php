<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableApplications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('vacancy_id')->unsigned();
            $table->enum('acceptness',['under_review','shortlisted','accepted','rejected','proposed']);
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('cv');
            $table->string('location');
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->integer('job_title_id')->nullable();
            $table->integer('job_category_id')->nullable();
            $table->date('applied_date')->nullable();
            $table->timestamps();
            // $table->foreign('vacancie_id')->references('id')->on('vacancies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('applications');
    }
}
