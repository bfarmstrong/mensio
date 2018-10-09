<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Creates a new table to keep track of the grid for matrix-type questions.
 */
class AddQuestionColumnsAndRows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('question_grids', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('index')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->enum('type', ['C', 'R']);
            $table->text('value');

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('question_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('question_grids');
    }
}
