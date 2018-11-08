<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGroupNoteIdToNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->integer('group_note_id')->unsigned();
            $table->foreign('group_note_id')
                ->references('id')
                ->on('group_notes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('group_note_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropForeign(['group_note_id']);
            $table->dropIndex(['group_note_id']);
            $table->dropColumn('group_note_id');
        });
    }
}
