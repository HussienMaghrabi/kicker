<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('relation')->nullable();
            $table->string('name');//fullname
            $table->integer('lead_id');
            $table->integer('title_id')->nullable();
            $table->integer('nationality')->nullable();//nationaltyid
            $table->string('phone')->nullable();
            $table->text('social')->nullable();
            $table->string('other_phones')->nullable();//mopile
            $table->string('email')->nullable();
            $table->string('other_emails')->nullable();
            $table->string('position')->nullable();
            $table->integer('company_id')->nullable();
            $table->enum('leadstatus', ['online', 'offline']);
            

            $table->timestamps('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
