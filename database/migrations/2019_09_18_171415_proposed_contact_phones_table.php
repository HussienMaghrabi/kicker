<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProposedContactPhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedContact_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone')->nullable($value=true);
            $table->string('mobile')->nullable($value=true);
            $table->unsignedInteger('contact_id')->nullable($value=true);
            $table->foreign('contact_id')->references('id')->on('contacts_proposed')->onDelete('cascade');

            

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
        Schema::table('proposedContact_phones', function (Blueprint $table) {
            //
        });
    }
}
