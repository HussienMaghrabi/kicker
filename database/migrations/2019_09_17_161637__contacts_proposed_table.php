<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactsProposedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_proposed', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name')->nullable($value=true);
            $table->string('last_name')->nullable($value=true);
            $table->string('website')->nullable($value=true);
            $table->string('position')->nullable($value=true);
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');
            $table->timestamps();

            $table->unsignedInteger('nationality_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts_proposed', function (Blueprint $table) {
            //
        });
    }
}
