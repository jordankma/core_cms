<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdNewsHasTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_news_has_tag', function (Blueprint $table) {
            $table->increments('news_has_tag_id')->comment('id');
            $table->integer('news_id',false,true);
            $table->integer('news_tag_id',false,true);
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->softDeletes();
            
            $table->foreign('news_id')->references('news_id')->on('dhcd_news')->onDelete('cascade');
            $table->foreign('news_tag_id')->references('news_tag_id')->on('dhcd_news_tag')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dhcd_news_has_tag');
    }
}
