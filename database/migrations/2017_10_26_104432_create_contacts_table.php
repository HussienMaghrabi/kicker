<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('nationality');
            $table->string('phone')->nullable();
            $table->string('other_phones')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('position')->nullable();
            $table->string('other_emails')->nullable();
            $table->enum('leadstatus', ['contacted', 'not_contacted']);
            $table->unsignedInteger('title_id');
            $table->unsignedInteger('company_id');
            $table->timestamps();

            $table->foreign('title_id')->references('id')->on('titles');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
