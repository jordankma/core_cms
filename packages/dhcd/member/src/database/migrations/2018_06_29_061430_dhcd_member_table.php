<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_member', function (Blueprint $table) {
            $table->increments('member_id');
            $table->string('token');
            $table->string('name');
            $table->string('u_name');
            $table->string('position')->nullable();
            $table->string('gender');
            $table->string('phone')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('address')->nullable();
            $table->string('don_vi')->nullable();
            $table->datetime('birthday')->nullable();
            $table->datetime('ngay_vao_dang')->nullable();
            $table->string('dan_toc')->nullable();
            $table->string('ton_giao')->nullable();
            $table->string('trinh_do_ly_luan')->nullable();
            $table->string('trinh_do_chuyen_mon')->nullable();
            $table->string('reg_ip')->nullable();
            $table->datetime('last_login')->nullable();
            $table->string('last_ip')->nullable();
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
        Schema::dropIfExists('dhcd_member');
    }
}
