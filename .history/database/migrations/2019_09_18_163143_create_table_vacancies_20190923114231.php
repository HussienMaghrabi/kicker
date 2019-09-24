<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableVacancies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacancies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('en_name');
            $table->string('ar_name')->nullable();
            $table->string('en_description')->nullable();
            $table->string('ar_description')->nullable();
            $table->enum('ar_description',['open','closed'])->nullable();
            $table->integer('job_title_id')->unsigned();
            $table->integer('vacancies_type_id')->unsigned();
            $table->foreign('job_title_id')->references('id')->on('job_titles');
            $table->foreign('vacancies_type_id')->references('id')->on('vacancies_type');
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
        Schema::dropIfExists('vacancies');
    }
}
