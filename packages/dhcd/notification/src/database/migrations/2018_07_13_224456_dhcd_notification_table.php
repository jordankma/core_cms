<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdNotificationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dhcd_notification', function (Blueprint $table) {
            $table->increments('notification_id');
            $table->string('name');
            $table->string('content')->nullable();
            $table->string('member_sent')->nullable();
            $table->datetime('time_sent')->nullable();
            $table->tinyInteger('type_sent', false, true)->comment('1 send all, 2 send theo lua chon')->default(1);
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
        Schema::dropIfExists('dhcd_notification');
    }
}
