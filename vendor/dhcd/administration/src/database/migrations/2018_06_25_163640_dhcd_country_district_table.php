<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdCountryDistrictTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_country_district', function (Blueprint $table) {
            $table->increments('country_district_id');
            $table->string('user_id')->comment('user_id cua nguoi dang tin');
            $table->integer('parent_code',false,true)->comment('user_id cua nguoi dang tin');
            $table->string('name')->comment('name');
            $table->string('alias')->comment('alias');
            $table->string('type')->comment('kieu thanh pho hay tinh');
            $table->string('name_with_type')->comment('ten theo kieu');
            $table->integer('code',false,true)->comment('ma tinh thanh pho');
            $table->string('path')->comment('');
            $table->string('path_with_type')->comment('');
            $table->tinyInteger('level', false, true)->comemt('cap')->default(2);
            $table->tinyInteger('visible', false, true)->comemt('an hien tin 1:hien 0:an')->default(1);
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            $table->timestamps();

            // $table->foreign('parent_code')->references('code')->on('dhcd_provine_city')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dhcd_country_district');
    }
}
