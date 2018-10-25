<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGroupNoteIdToGroupNotes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_notes', function (Blueprint $table) {
            $table->integer('note_id')->unsigned()->nullable();
            $table->foreign('note_id')
                ->references('id')
                ->on('group_notes')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('note_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_notes', function (Blueprint $table) {
            $table->dropForeign(['note_id']);
            $table->dropIndex(['note_id']);
            $table->dropColumn('note_id');
        });
    }
}
