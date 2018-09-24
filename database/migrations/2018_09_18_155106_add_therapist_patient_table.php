<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a table to connect therapists to patients.
 */
class AddTherapistPatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('therapist_patient', function (Blueprint $table) {
            $table->increments('id');

            $table->boolean('active')->default(true);
            $table->uuid('patient_id');
            $table->uuid('therapist_id');

            $table->foreign('patient_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('patient_id');

            $table->foreign('therapist_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('therapist_id');

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
        Schema::dropIfExists('therapist_patient');
    }
}
