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
        Schema::connection('mysql_dhcd')->create('dhcd_member', function (Blueprint $table) {
            $table->increments('member_id');
            $table->string('token')->nullable();
            $table->string('name');
            $table->tinyInteger('type')->default('1')->comment('1 dai bieu chinh thuc 2 dai bieu moi');
            $table->string('u_name')->unique();
            $table->string('password');
            $table->string('position')->nullable();
            $table->string('gender')->nullable();
            $table->string('phone')->unique();
            $table->string('email')->unique();
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
            
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            
            $table->rememberToken();
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
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_member');
    }
}
