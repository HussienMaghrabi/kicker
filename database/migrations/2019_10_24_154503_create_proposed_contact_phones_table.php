<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposedContactPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedContact_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->unsignedInteger('contact_id');
            $table->foreign('contact_id')->references('id')->on('contacts_proposed');
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('proposed_company');

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
        Schema::dropIfExists('proposedContact_phones');
    }
}
