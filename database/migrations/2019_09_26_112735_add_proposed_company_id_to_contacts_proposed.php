<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProposedCompanyIdToContactsProposed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts_proposed', function($table) {
            $table->unsignedInteger('proposed_company_id')->nullable($value=true);
            $table->foreign('proposed_company_id')->references('id')->on('proposed_company')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
