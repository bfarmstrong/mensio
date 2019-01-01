<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Ensure that the health card blind index is allowed to be null.
 */
class MakeHealthCardBlindIndexNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE users MODIFY health_card_number_bidx VARCHAR(512)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE users MODIFY health_card_number_bidx VARCHAR(191) NOT NULL');
    }
}
