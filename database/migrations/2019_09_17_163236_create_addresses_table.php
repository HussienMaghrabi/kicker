<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('street')->nullable($value=true);
            $table->string('state')->nullable($value=true);
            $table->string('zip_code')->nullable($value=true);
            $table->unsignedInteger('company_id')->nullable($value=true);
            $table->unsignedInteger('country_id')->nullable($value=true);
            $table->unsignedInteger('city_id')->nullable($value=true);
            $table->timestamps();

            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('no action');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addresses');
    }
}
