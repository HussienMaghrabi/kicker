<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeeContact extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contact', function (Blueprint $table) {
            $table->increments('id');
            $table->string('relation')->nullable();
            $table->string('name');
            $table->integer('lead_id')->unsigned();
            $table->integer('employee_id')->unsigned();
            $table->integer('title_id')->unsigned();
            $table->string('email');
            $table->string('phone');
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
        Schema::dropIfExists('employee_contact');
    }
}
