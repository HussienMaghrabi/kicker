<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposedContactEmailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedContact_emails', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->unsignedInteger('proposed_company_id')->nullable($value=true);
            $table->unsignedInteger('contact_id')->nullable($value=true);
            $table->timestamps();

            $table->foreign('proposed_company_id')->references('id')->on('proposed_company')->onDelete('cascade');
            $table->foreign('contact_id')->references('id')->on('contacts_proposed')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposedContact_emails', function (Blueprint $table) {
            //
        });
    }
}
