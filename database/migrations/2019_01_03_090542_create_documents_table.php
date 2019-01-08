<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->increments('id');
			$table->string('name');
			$table->text('file_location');
			$table->text('file_name');
			$table->text('file_size');
			$table->text('mime_type');
			$table->text('user_id');
			$table->text('digital_signature');
			$table->text('description');
			$table->uuid('uuid');
			$table->text('date');
			$table->integer('document_type')->unsigned()->comment = '1-Notes,2-Other attachments';
			$table->integer('clinic_id')->unsigned();
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
        Schema::dropIfExists('documents');
    }
}
