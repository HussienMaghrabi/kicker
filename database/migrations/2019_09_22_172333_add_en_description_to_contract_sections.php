<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEnDescriptionToContractSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contract_sections', function($table) {
            $table->string('en_description');
            $table->string('ar_description');
            $table->unsignedInteger('user_id')->nullable($value=true);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
