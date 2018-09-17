<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivityLogTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('activitylog.table_name'), function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->uuid('subject_id')->nullable();
            $table->string('subject_type')->nullable();
            $table->uuid('causer_id')->nullable();
            $table->string('causer_type')->nullable();
            $table->text('properties')->nullable();
            $table->timestamps();

            $table->index('causer_id');
            $table->index('log_name');
            $table->index('subject_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(config('activitylog.table_name'));
    }
}
