<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposedCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposed_company', function (Blueprint $table) {
            $table->increments('id');
            //$table->unsignedInteger('company_id');
           // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->unsignedInteger('contact_id');
            // $table->foreign('contact_id')->references('id')->on('contacts_proposed')->onDelete('cascade');
            // $table->unsignedInteger('address_id');
            // $table->foreign('address_id')->references('id')->on('proposedCompany_addresses')->onDelete('cascade');
            $table->string('name');
            $table->string('activity');
            $table->string('introduction');
            $table->string('closing');
            $table->string('policy');
            $table->text('image');
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
        Schema::table('proposed_company', function (Blueprint $table) {
            //
        });
    }
}
