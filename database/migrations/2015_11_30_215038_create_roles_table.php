<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->integer('level');
            $table->string('label')->nullable();
            $table->text('permissions')->nullable();
        });
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role_id')->unsigned()->index()->nullable();
            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('roles');
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('role_id');
            $table->dropColumn('role_id');
        });
    }
}
