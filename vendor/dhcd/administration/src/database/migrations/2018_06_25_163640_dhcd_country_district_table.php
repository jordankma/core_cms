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
        Schema::connection('mysql_dhcd')->create('dhcd_country_district', function (Blueprint $table) {
            $table->increments('country_district_id');
            $table->string('create_by');
            $table->integer('provine_city_id',false,true)->nullable();
            $table->string('name')->comment('name');
            $table->string('alias')->comment('alias');
            $table->string('type')->comment('kieu thanh pho hay tinh');
            $table->string('name_with_type')->comment('ten theo kieu')->nullable();
            $table->string('path')->comment('')->nullable();
            $table->string('path_with_type')->comment('')->nullable();
            $table->tinyInteger('level', false, true)->comemt('cap')->default(2)->nullable();
            $table->tinyInteger('status', false, true)->comment('trang thai')->default(1);
            $table->timestamps();
            $table->softDeletes();
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
        Schema::connection('mysql_dhcd')->dropIfExists('dhcd_country_district');
    }
}
