<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_news', function (Blueprint $table) {
            $table->increments('news_id');
            $table->string('user_id')->comment('user_id cua nguoi dang tin');
            $table->string('news_cat')->comment('json chua cac chuyen muc');
            $table->string('news_tag')->comment('json chua cac tag');
            $table->string('title')->comment('tieu de');
            $table->string('title_alias')->comment('alias cua tieu de');
            $table->longText('desc')->comment('doan mo ta ngan tin')->nullable();
            $table->longText('content')->comment('noi dung tin')->nullable();
            $table->string('image')->comment('url anh tin tuc')->nullable();
            $table->tinyInteger('is_hot')->comment('1: tin hot 0: tin thuong');
            $table->integer('priority')->comment('thu tu uu tien cua tin de hien thi')->nullable();
            $table->string('key_word_seo')->comment('json cac tu khoa seo');
            $table->string('desc_seo')->comment('mo ta cua seo');
            $table->tinyInteger('visible', false, true)->comemt('an hien tin 1:hien 0:an')->default(1);
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
        Schema::dropIfExists('dhcd_news');
    }
}
