<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DhcdCommuneGuildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_dhcd')->create('dhcd_commune_guild', function (Blueprint $table) {
            $table->increments('commune_guild_id');
            $table->string('create_by');
            $table->integer('country_district_id',false,true);
            $table->integer('provine_city_id',false,true);
            $table->string('name')->comment('name');
            $table->string('alias')->comment('alias');
            $table->string('type')->comment('kieu thanh pho hay tinh');
            $table->string('name_with_type')->comment('ten theo kieu')->nullable();
            $table->string('path')->comment('')->nullable();
            $table->string('path_with_type')->comment('')->nullable();
            $table->tinyInteger('level', false, true)->comemt('cap')->default(3)->nullable();
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('parent_code')->references('code')->on('dhcd_country_district')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_commune_guild');
    }
}
