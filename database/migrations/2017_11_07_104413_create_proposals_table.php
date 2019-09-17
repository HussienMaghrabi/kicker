<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProposalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proposals', function (Blueprint $table) {
            $table->increments('id');
            $table->text('introduction')->nullable($value=true);
            $table->text('closing')->nullable($value=true);
            $table->date('valid_until')->nullable($value=true);
            $table->text('policy')->nullable($value=true);
            $table->text('payment')->nullable($value=true);
            $table->string('sub_total')->nullable($value=true);
            $table->string('discount')->nullable($value=true);
            $table->string('total')->nullable($value=true);
            $table->unsignedInteger('company_id')->nullable($value=true);
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedInteger('contact_id')->nullable($value=true);
            $table->foreign('contact_id')->references('id')->on('contacts')->onDelete('cascade');
            $table->unsignedInteger('currency_id')->nullable($value=true);
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
             
                $table->enum('personal_commercial',['personal','commercial']);
                $table->enum('unit_type',['resale','rental','new_home','land']);
                $table->unsignedInteger('unit_id');
                $table->unsignedInteger('lead_id');
                $table->text('description');
                $table->string('price');
                $table->text('file')->nullable();
                $table->unsignedInteger('user_id');
                $table->enum('status',['pending','confirmed']);
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
        Schema::dropIfExists('proposals');
    }
}
