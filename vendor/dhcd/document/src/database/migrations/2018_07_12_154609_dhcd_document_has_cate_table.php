<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdDocumentHasCateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('package_document_has_cate', function (Blueprint $table) {
            $table->increments('document_has_cate_id');
            $table->integer('document_cate_id')->unsigned();
            $table->foreign('document_cate_id')->references('document_cate_id')->on('package_document_cates');
            $table->integer('document_id')->unsigned();
            $table->foreign('document_id')->references('document_id')->on('package_documents');
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
        Schema::connection('mysql_dhcd')->dropIfExists('package_document_has_cate');
    }
}
