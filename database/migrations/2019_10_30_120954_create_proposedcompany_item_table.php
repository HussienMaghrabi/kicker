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
            $table->unsignedInteger('proposed_company_id')->nullable();
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('proposed_company_id')->references('id')->on('proposed_company')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
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
