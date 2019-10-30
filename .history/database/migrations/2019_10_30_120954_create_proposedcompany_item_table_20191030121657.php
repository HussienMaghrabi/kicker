<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposedcompanyItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposedcompany_item', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposed_company_id')->unsignedInteger();
            $table->integer('item_id')->unsignedInteger();
            $table->foreign('proposed_company_id')->references('id')->on('proposed_company');
            $table->foreign('item_id')->references('id')->on('items');
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
        Schema::dropIfExists('proposedcompany_item');
    }
}
