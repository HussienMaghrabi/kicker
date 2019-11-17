<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposedCompanyAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedCompany_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street')->nullable($value=true);
            $table->string('state')->nullable($value=true);
            $table->string('zip_code')->nullable($value=true);
            $table->unsignedInteger('proposed_company_id')->nullable($value=true);
            $table->unsignedInteger('country_id')->nullable($value=true);
            $table->unsignedInteger('city_id')->nullable($value=true);
            $table->timestamps();

            $table->foreign('proposed_company_id')->references('id')->on('proposed_company')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('proposedCompany_addresses', function (Blueprint $table) {
            //
        });
    }
}
