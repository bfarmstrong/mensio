<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds an index to the UUID field on some tables.
 */
class AddUuidIndicesToResponsesAndRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->index('uuid');
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->index('uuid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('responses', function (Blueprint $table) {
            $table->dropIndex(['uuid']);
        });

        Schema::table('roles', function (Blueprint $table) {
            $table->dropIndex(['uuid']);
        });
    }
}
