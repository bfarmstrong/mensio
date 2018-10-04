<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds the questions and question items tables to the database.
 */
class AddQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->increments('id');

            $table->text('label');
            $table->string('name');
            $table->integer('questionnaire_id')->unsigned();
            $table->string('rules')->nullable();
            $table->string('type');

            $table->foreign('questionnaire_id')
                ->references('id')
                ->on('questionnaires')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('questionnaire_id');

            $table->timestamps();
        });

        Schema::create('question_items', function (Blueprint $table) {
            $table->increments('id');

            $table->text('name');
            $table->integer('question_id')->unsigned();
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
        Schema::dropIfExists('question_items');
        Schema::dropIfExists('questions');
    }
}
