<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ContactsProposedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts_proposed', function (Blueprint $table) {
            $table->increments('id');
            // $table->string('relation')->nullable();
            $table->string('first_name')->nullable($value=true);
            $table->string('last_name')->nullable($value=true);
            $table->string('website')->nullable($value=true);
            $table->string('position')->nullable($value=true);
             $table->unsignedInteger('nationality_id')->nullable();
            $table->foreign('nationality_id')->references('id')->on('nationalities')->onDelete('cascade');

            // $table->string('phone')->nullable();
            // $table->string('mobile')->nullable();
            // $table->enum('leadstatus', ['contacted', 'not_contacted']);
            // $table->string('position')->nullable();
            // $table->unsignedInteger('lead_source_id');
            // $table->foreign('lead_source_id')->references('id')->on('lead_sources');
            // $table->unsignedInteger('title_id')->nullable();
            // $table->foreign('title_id')->references('id')->on('titles');
            // $table->text('social')->nullable();
            // $table->string('other_phones')->nullable();
            // $table->string('email')->nullable();
            // $table->string('other_emails')->nullable();
            // $table->unsignedInteger('company_id')->nullable();
            // $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            // $table->enum('leadstatus', ['online', 'offline']);
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
        Schema::table('contacts_proposed', function (Blueprint $table) {
            //
        });
    }
}
