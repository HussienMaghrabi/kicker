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
        Schema::table('proposedContact_phones', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone');
            $table->unsignedInteger('proposed_company_id')->nullable($value=true);
            $table->timestamps();

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
        Schema::dropIfExists('collections');
    }
}
