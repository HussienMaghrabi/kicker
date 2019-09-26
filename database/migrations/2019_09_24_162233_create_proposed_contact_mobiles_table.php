<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposedContactMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposed_contact_mobiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile')->nullable($value=true);
            $table->unsignedInteger('contact_id')->nullable($value=true);
            $table->foreign('contact_id')->references('id')->on('contacts_proposed')->onDelete('cascade');

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
        Schema::dropIfExists('proposed_contact_mobiles');
    }
}
