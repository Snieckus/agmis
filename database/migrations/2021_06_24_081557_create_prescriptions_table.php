<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('drug_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('valid_until');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('drug_id')->references('id')->on('drugs');

            $table->index('user_id');
            $table->index('drug_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescriptions');
    }
}
