<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a doctor and referrer to the users table.
 */
class AddDoctorAndReferrerToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->foreign('doctor_id')
                ->references('id')
                ->on('doctors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('doctor_id');

            $table->integer('referrer_id')->unsigned()->nullable();
            $table->foreign('referrer_id')
                ->references('id')
                ->on('doctors')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('referrer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['doctor_id']);
            $table->dropIndex(['doctor_id']);
            $table->dropColumn('doctor_id');

            $table->dropForeign(['referrer_id']);
            $table->dropIndex(['referrer_id']);
            $table->dropColumn('referrer_id');
        });
    }
}
