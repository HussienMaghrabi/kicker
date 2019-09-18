<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_name');
            $table->stirng('email');
            $table->string('password');
            $table->string('phone');
            $table->string('image');
            $table->string('remember_token');
            $table->integer('role_id');
            $table->string('type');
            $table->string('refresh_token');
            $table->string('lastseen_dash');
            $table->string('lastseen_mod');
            $table->string('essistant');
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
        Schema::dropIfExists('users');
    }
}
