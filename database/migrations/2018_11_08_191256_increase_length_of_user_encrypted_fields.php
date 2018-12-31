<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Increases the size of all encrypted fields that are stored as VARCHAR.
 */
class IncreaseLengthOfUserEncryptedFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('ALTER TABLE attachments MODIFY file_location VARCHAR(512)');
        DB::statement('ALTER TABLE attachments MODIFY file_name VARCHAR(512)');
        DB::statement('ALTER TABLE attachments MODIFY file_size VARCHAR(512)');
        DB::statement('ALTER TABLE attachments MODIFY mime_type VARCHAR(512)');

        DB::statement('ALTER TABLE users MODIFY address_line_1 VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY address_line_2 VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY city VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY country VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY emergency_name VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY emergency_phone VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY emergency_relationship VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY health_card_number VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY home_phone VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY license VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY name VARCHAR(512) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY name_bidx VARCHAR(512) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY notes VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY phone VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY postal_code VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY province VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY work_phone VARCHAR(512)');
        DB::statement('ALTER TABLE users MODIFY written_signature VARCHAR(512)');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('ALTER TABLE attachments MODIFY file_location VARCHAR(191)');
        DB::statement('ALTER TABLE attachments MODIFY file_name VARCHAR(191)');
        DB::statement('ALTER TABLE attachments MODIFY file_size VARCHAR(191)');
        DB::statement('ALTER TABLE attachments MODIFY mime_type VARCHAR(191)');

        DB::statement('ALTER TABLE users MODIFY address_line_1 VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY address_line_2 VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY city VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY country VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY emergency_name VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY emergency_phone VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY emergency_relationship VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY health_card_number VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY home_phone VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY license VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY name VARCHAR(191) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY name_bidx VARCHAR(191) NOT NULL');
        DB::statement('ALTER TABLE users MODIFY notes VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY phone VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY postal_code VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY province VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY work_phone VARCHAR(191)');
        DB::statement('ALTER TABLE users MODIFY written_signature VARCHAR(191)');
    }
}
