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
