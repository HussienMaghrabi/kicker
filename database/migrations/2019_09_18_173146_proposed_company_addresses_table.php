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
        Schema::table('proposedCompany_addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street')->nullable($value=true);
            $table->string('state')->nullable($value=true);
            $table->string('zip_code')->nullable($value=true);
            $table->unsignedInteger('company_id')->nullable($value=true);
            $table->foreign('company_id')->references('id')->on('proposed_company')->onDelete('cascade');
            $table->unsignedInteger('city_id')->nullable($value=true);
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->unsignedInteger('country_id')->nullable($value=true);
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
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
        Schema::table('proposedCompany_addresses', function (Blueprint $table) {
            //
        });
    }
}
