<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a label field to a question item.  This is what is displayed inside of
 * the select box.  If no label is set then the value is used.
 */
class AddLabelToQuestionItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('question_items', function (Blueprint $table) {
            $table->text('label')->nullable();
            $table->text('value')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('question_items', function (Blueprint $table) {
            $table->dropColumn('label');
            $table->text('value')->nullable(false)->change();
        });
    }
}
