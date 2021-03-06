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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone');
            $table->unsignedInteger('agent_type_id');
            $table->unsignedInteger('user_id');
            $table->string('image');
            $table->string('remember_token', 100);
            $table->string('commission')->nullable();
            $table->text('email_password')->nullable();
            $table->enum('type',['admin','agent']);
            $table->integer('role_id');
            $table->string('refresh_token');
            $table->integer('last_seen_dash')->nullable();
            $table->integer('last_seen_mob')->nullable();
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
