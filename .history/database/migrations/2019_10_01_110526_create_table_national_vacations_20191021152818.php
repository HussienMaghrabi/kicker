<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableNationalVacations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('national_vacation', function (Blueprint $table) {
            $table->increments('id');
            $table->string('en_name');
            $table->string('ar_name')->nullable();
            $table->integer('days');
            $table->enum('natoial_vacation_type_id',['national_vication','free_vication'])->nullable();
            $table->date('from');
            $table->date('to');
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
        Schema::dropIfExists('national_vacation');
    }
}
