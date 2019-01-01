<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds an auto-generated UUID column to each table that is currently missing
 * one.
 */
class AddUuidsToSomeLoggableTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->index('uuid');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->index('uuid');
        });

        Schema::table('question_grids', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->index('uuid');
        });

        Schema::table('question_items', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->index('uuid');
        });

        Schema::table('questionnaires', function (Blueprint $table) {
            $table->uuid('uuid');
            $table->index('uuid');
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->uuid('uuid');
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
        Schema::table('answers', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('question_grids', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('question_items', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('questionnaires', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });

        Schema::table('surveys', function (Blueprint $table) {
            $table->dropColumn('uuid');
        });
    }
}
