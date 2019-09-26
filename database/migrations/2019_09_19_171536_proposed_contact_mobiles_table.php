<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposedContactMobilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedContact_mobiles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('mobile');
            $table->unsignedInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts_proposed');
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
        Schema::table('proposedContact_mobiles', function (Blueprint $table) {
            //
        });
    }
}
