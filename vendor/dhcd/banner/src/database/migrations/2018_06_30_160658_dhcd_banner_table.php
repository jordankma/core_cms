<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdBannerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_banner', function (Blueprint $table) {
            $table->increments('banner_id');
            $table->string("create_by")->nullable();
            $table->string("name");
            $table->string("alias");
            $table->string("desc")->nullable();
            $table->string("image");
            $table->string("link")->nullable();
            $table->integer("count_view",false,true)->comment('số lượng người click')->nullable();
            $table->integer("position", false, true)->comment('vi tri banner')->default('0');
            $table->integer("priority", false, true)->comment('thứ tự ưu tiên')->default('1');
            $table->datetime("close_at")->comment('han hien thị banner');
            $table->tinyInteger('visible', false, true)->comemt('an hien tin 1:hien 0:an')->default(1);
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
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
        Schema::dropIfExists('dhcd_banner');
    }
}
