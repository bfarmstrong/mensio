<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds client-centric fields to the users table.
 */
class AddStaticFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // User home address
            $table->string('address_line_1')->nullable();
            $table->string('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('country')->nullable();

            // User alternate phone numbers
            $table->string('home_phone')->nullable();
            $table->string('work_phone')->nullable();

            // User preferred contact method
            $table->enum('preferred_contact_method', ['EM', 'PH'])->default('PH');

            // User emergency contact information
            $table->string('emergency_name')->nullable();
            $table->string('emergency_phone')->nullable();
            $table->string('emergency_relationship')->nullable();

            // User health insurance information
            $table->string('health_card_number')->nullable();

            // User general notes
            $table->text('notes')->nullable();
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
            $table->dropColumn('address_line_1');
            $table->dropColumn('address_line_2');
            $table->dropColumn('city');
            $table->dropColumn('province');
            $table->dropColumn('postal_code');
            $table->dropColumn('country');

            $table->dropColumn('home_phone');
            $table->dropColumn('work_phone');

            $table->dropColumn('preferred_contact_method');

            $table->dropColumn('emergency_name');
            $table->dropColumn('emergency_phone');
            $table->dropColumn('emergency_relationship');

            $table->dropColumn('health_card_number');

            $table->dropColumn('notes');
        });
    }
}
