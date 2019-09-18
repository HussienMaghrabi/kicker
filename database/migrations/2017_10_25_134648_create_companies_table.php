<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('industry_id');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->text('notes')->nullable();
            $table->integer('user_id');
            $table->integer('annual_revenue');
            $table->integer('lead_source_id');
            $table->integer('contract_id');
            $table->string('introduction');
            $table->string('closing');
            $table->string('policy');          
            $table->enum('leadstatus', ['online', 'offline']);
            $table->string('activity');
            $table->string('company_type');
            $table->integer('sub_id');
            $table->integer('invoice_id');
            $table->integer('currency_id');
            $table->integer('tax_bill');
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
        Schema::dropIfExists('companies');
    }
}
