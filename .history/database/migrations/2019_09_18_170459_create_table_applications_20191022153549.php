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
            $table->integer('vacancie_id')->unsigned();
            $table->integer('acceptness_id')->unsigned();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('cv');
            $table->string('location');
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->integer('job_title')->nullable();
            $table->integer('job_category_id')->nullable();
            $table->date('applied_date')->nullable();
            $table->timestamps();
            // $table->foreign('vacancie_id')->references('id')->on('vacancies');
            // $table->foreign('acceptness_id')->references('id')->on('acceptness');
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
