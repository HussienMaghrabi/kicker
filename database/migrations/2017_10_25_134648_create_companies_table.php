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
            $table->unsignedInteger('industry_id');
            $table->foreign('industry_id')->references('id')->on('industries');
            $table->integer('employees_Number');
            $table->enum('rating',['1','2','3','4','5']);
            $table->text('logo');
            $table->string('description');
            $table->integer('annual_revenue');    
            $table->unsignedInteger('lead_source_id');
            $table->foreign('lead_source_id')->references('id')->on('lead_sources');
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
