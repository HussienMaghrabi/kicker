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
            // $table->string('relation')->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedInteger('lead_source_id');
            $table->foreign('lead_source_id')->references('id')->on('lead_sources');
            $table->unsignedInteger('title_id');
            $table->foreign('title_id')->references('id')->on('titles');
            $table->string('nationality');
            // $table->integer('nationality')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            // $table->text('social')->nullable();
            $table->string('other_phones')->nullable();
            $table->string('email')->nullable();
            $table->string('other_emails')->nullable();
            $table->string('position')->nullable();
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->enum('leadstatus', ['contacted', 'not_contacted']);
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
        Schema::dropIfExists('contacts');
    }
}
