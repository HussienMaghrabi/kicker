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
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->nullable();
            $table->string('fax')->nullable();
            $table->unsignedInteger('industry_id');
            $table->integer('employees_Number');
            $table->enum('rating',['1','2','3','4','5']);
            $table->text('logo');
            $table->string('description');
            $table->integer('annual_revenue');    
            $table->unsignedInteger('lead_source_id');
            $table->enum('lead_type',['company','individual']);
            $table->enum('lead_privacy',['only_me','friends','public']);
            $table->timestamps();

            $table->foreign('industry_id')->references('id')->on('industries');
            $table->foreign('lead_source_id')->references('id')->on('lead_sources');
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
