<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropsalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propsal_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proposal_id');
            $table->integer('item_id');
            $table->integer('quantity');
            $table->double('line_total');
            $table->double('discaount');
            $table->double('final_total');
            $table->double('total');
            $table->text('payment')->nullable();
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
        Schema::dropIfExists('propsal_items');
    }
}
