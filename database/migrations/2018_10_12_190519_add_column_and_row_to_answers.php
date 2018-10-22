<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds column and row attribute to the answers table.
 */
class AddColumnAndRowToAnswers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('answers', function (Blueprint $table) {
            $table->integer('column_id')->unsigned()->nullable();
            $table->integer('row_id')->unsigned()->nullable();

            $table->foreign('column_id')
                ->references('id')
                ->on('question_grids')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('column_id');

            $table->foreign('row_id')
                ->references('id')
                ->on('question_grids')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('row_id');
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
            $table->dropForeign(['column_id']);
            $table->dropIndex(['column_id']);
            $table->dropColumn('column_id');

            $table->dropForeign(['row_id']);
            $table->dropIndex(['row_id']);
            $table->dropColumn('row_id');
        });
    }
}
