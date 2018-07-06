<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdProvineCityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_provine_city', function (Blueprint $table) {
            $table->increments('provine_city_id');
            $table->string('user_id')->comment('user_id cua nguoi dang tin');
            $table->string('name')->comment('name');
            $table->string('alias')->comment('alias');
            $table->string('type')->comment('kieu thanh pho hay tinh');
            $table->string('name_with_type')->comment('ten theo kieu');
            $table->integer('code',false,true)->comment('ma tinh thanh pho');
            $table->tinyInteger('level', false, true)->comemt('cap')->default(1);
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
        Schema::dropIfExists('dhcd_provine_city');
    }
}
