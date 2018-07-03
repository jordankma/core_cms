<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_topic', function (Blueprint $table) {
            $table->increments('topic_id');
            $table->string('name');
            $table->string('alias');
            $table->tinyInteger('is_hot', false, true)->comemt('an hien tin 1:hien 0:an')->default(0);
            $table->tinyInteger('visible', false, true)->comemt('an hien tin 1:hien 0:an')->default(1);
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(0);
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
        Schema::dropIfExists('dhcd_topic');
    }
}
