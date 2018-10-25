<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds an index for the uuid fields.
 */
class AddMissingUuidIndices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('groups', function (Blueprint $table) {
            $table->index('uuid');
        });

        Schema::table('doctors', function (Blueprint $table) {
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
        Schema::table('groups', function (Blueprint $table) {
            $table->dropIndex(['uuid']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropIndex(['uuid']);
        });
    }
}
