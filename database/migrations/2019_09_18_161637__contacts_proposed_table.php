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
            $table->string('first_name');
            $table->string('last_name');
            $table->unsignedInteger('phone_id');
            $table->foreign('phone_id')->references('id')->on('proposedContact_phones');
            $table->unsignedInteger('mobile_id');
            $table->foreign('mobile_id')->references('id')->on('proposedContact_mobiles');
            $table->unsignedInteger('fax_id');
            $table->foreign('fax_id')->references('id')->on('proposedContact_faxes');
            $table->unsignedInteger('email_id');
            $table->foreign('email_id')->references('id')->on('proposedContact_emails');
            $table->string('nationality');
            $table->string('website');
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
