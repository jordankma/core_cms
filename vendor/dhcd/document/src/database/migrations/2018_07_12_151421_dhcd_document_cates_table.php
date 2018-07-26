<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdDocumentCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('package_document_cates', function (Blueprint $table) {
            $table->increments('document_cate_id');
            $table->string('parent_id');
            $table->string('name');
            $table->string('alias');
            $table->string('icon');
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);          
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dhcd')->dropIfExists('package_document_cates');
    }
}
