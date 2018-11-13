<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Makes the client identifier in the notes table a nullable value.
 */
class AlterNotesTableForNullableClientId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE notes MODIFY client_id CHAR(36)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE notes MODIFY client_id CHAR(36) NOT NULL');
    }
}
