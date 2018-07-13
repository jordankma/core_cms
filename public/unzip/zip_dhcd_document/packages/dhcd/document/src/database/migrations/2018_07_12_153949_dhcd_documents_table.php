<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql')->create('documents', function (Blueprint $table) {
            $table->increments('document_id');            
            
            $table->integer('document_type_id')->unsigned();
            $table->foreign('document_type_id')->references('document_type_id')->on('document_types');
            
            $table->string('name');
            $table->string('file');
            $table->string('descript');
            $table->integer('status')->default(1);
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
        Schema::connection('mysql')->dropIfExists('documents');
    }
}
