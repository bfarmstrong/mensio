<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds digital signature capabilities to attachments and communication logs.
 */
class AddDigitalSignatureToCommunicationLogAndAttachments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->uuid('therapist_id');
            $table->text('digital_signature')->nullable();

            $table->foreign('therapist_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('therapist_id');
        });

        Schema::table('communication_logs', function (Blueprint $table) {
            $table->text('digital_signature')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attachments', function (Blueprint $table) {
            $table->dropColumn('digital_signature');
            $table->dropColumn('therapist_id');
        });

        Schema::table('communication_logs', function (Blueprint $table) {
            $table->dropColumn('digital_signature');
        });
    }
}
