<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->dateTime('datetime');
            $table->unsignedBigInteger('doctor_id');
            $table->tinyInteger('is_temp')->default(0);
            $table->unsignedBigInteger('user_created');
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('users');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->foreign('user_created')->references('id')->on('users');

            $table->index('patient_id');
            $table->index('doctor_id');
            $table->index('user_created');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('appointments');
    }
}
