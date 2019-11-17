<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposedCurrencyCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedCurrency_companies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('currency_id')->nullable($value=true);
            $table->unsignedInteger('proposed_company_id')->nullable($value=true);
            $table->timestamps();

            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
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
        Schema::dropIfExists('proposedCurrency_companies');
    }
}
