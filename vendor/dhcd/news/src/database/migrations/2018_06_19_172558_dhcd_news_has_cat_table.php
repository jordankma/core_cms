<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdNewsHasCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_news_has_cat', function (Blueprint $table) {
            $table->increments('news_has_cat_id');
            $table->integer('news_id', false, true)->index();
            $table->integer('news_cat_id', false, true)->index();
            $table->timestamps();
            $table->engine = 'InnoDB';
            $table->foreign('news_id')->references('news_id')->on('dhcd_news')->onDelete('cascade');
            $table->foreign('news_cat_id')->references('news_cat_id')->on('dhcd_news_cat')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dhcd_news_has_cat');
    }
}
