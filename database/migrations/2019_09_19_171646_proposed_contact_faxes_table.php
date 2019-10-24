<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposedContactFaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedContact_faxes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fax');
            $table->unsignedInteger('contact_id')->nullable($value=true);
            $table->foreign('contact_id')->references('id')->on('contacts_proposed')->onDelete('cascade');
            $table->unsignedInteger('proposed_company_id')->nullable($value=true);
            $table->foreign('proposed_company_id')->references('id')->on('proposed_company')->onDelete('cascade');
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
        Schema::table('proposedContact_faxes', function (Blueprint $table) {
            //
        });
    }
}
