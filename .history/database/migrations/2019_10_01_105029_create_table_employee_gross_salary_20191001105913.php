<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableEmployeeGrossSalary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('create_gross_salary', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->string('details')->nullable();
            $table->date('date');
            $table->string('allowanes')->nullable();
            $table->string('order_by')->nullable();
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
        Schema::dropIfExists('create_gross_salary');
    }
}
