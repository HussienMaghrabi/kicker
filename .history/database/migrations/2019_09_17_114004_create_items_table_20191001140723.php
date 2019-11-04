<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable($value=true);
            $table->text('description')->nullable($value=true);
            $table->unsignedInteger('quantity')->nullable($value=true);
            $table->string('unit_price')->nullable($value=true);
            $table->string('sub_total')->nullable($value=true);
            $table->string('discount_value')->nullable($value=true);
            $table->string('discount_percentage')->nullable($value=true);
            $table->string('total')->nullable($value=true);
            $table->unsignedInteger('company_id')->nullable($value=true);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedInteger('proposal_id')->nullable($value=true);
            $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('cascade');
            
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
        Schema::dropIfExists('items');
    }
}
