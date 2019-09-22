<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRequestMenuItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_menu_items', function (Blueprint $table) {
           

            $table->increments('id');
            $table->string('restaurant_name');
            $table->string('restaurant_phone_number');
            $table->string('item_name');
            $table->string('notes');
            $table->unsignedInteger('restaurant_id');
            $table->foreign('restaurant_id')->references('id')->on('request_items');
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
        Schema::dropIfExists('request_menu_items');
    }
}
