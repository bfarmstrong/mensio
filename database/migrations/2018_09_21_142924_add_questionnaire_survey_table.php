<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds a pivot table to connect the questionnaire and survey models.
 */
class AddQuestionnaireSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questionnaire_survey', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('questionnaire_id')->unsigned();
            $table->integer('survey_id')->unsigned();

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
        Schema::dropIfExists('questionnaire_survey');
    }
}
