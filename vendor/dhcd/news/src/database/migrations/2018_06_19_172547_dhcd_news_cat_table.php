<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdNewsCatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_news_cat', function (Blueprint $table) {
            $table->increments('news_cat_id');
            $table->integer('parent_news_cat_id')->comment('id cua chuyen muc cha');
            $table->string('name');
            $table->string('cat_alias');
            $table->tinyInteger('status')->comment('1 duyet 0 cho duyet')->default(0);    
            $table->tinyInteger('visible')->comment('1 hien 0 an')->default(1);  
            $table->timestamps();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dhcd_news_cat');
    }
}