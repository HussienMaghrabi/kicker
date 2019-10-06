<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('failedJobs', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('status', ['online', 'offline']);
            $table->string('queue',50);
            $table->string('payload',50);
            $table->string('exception');
            $table->date('failed_at');
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
        Schema::dropIfExists('failedJobs');
    }
}
