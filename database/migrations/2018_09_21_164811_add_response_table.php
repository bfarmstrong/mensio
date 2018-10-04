<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Add all of the database tables for user responses to questionnaires.
 */
class AddResponseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('responses', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('questionnaire_id')->unsigned();
            $table->integer('survey_id')->unsigned();
            $table->uuid('user_id');

            $table->foreign('questionnaire_id')
                ->references('id')
                ->on('questionnaires')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('questionnaire_id');

            $table->foreign('survey_id')
                ->references('id')
                ->on('surveys')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('survey_id');

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('user_id');

            $table->timestamps();
        });

        Schema::create('answers', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('response_id')->unsigned();
            $table->integer('question_id')->unsigned();
            $table->integer('question_item_id')->unsigned()->nullable();
            $table->text('value')->nullable();

            $table->foreign('response_id')
                ->references('id')
                ->on('responses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('response_id');

            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('question_id');

            $table->foreign('question_item_id')
                ->references('id')
                ->on('question_items')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('question_item_id');

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
        Schema::dropIfExists('answers');
        Schema::dropIfExists('responses');
    }
}
