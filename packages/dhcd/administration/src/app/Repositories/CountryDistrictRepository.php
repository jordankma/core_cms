<?php

namespace Dhcd\Administration\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use DB;
/**
 * Class DemoRepository
 * @package Dhcd\Administration\Repositories
 */
class CountryDistrictRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Administration\App\Models\CountryDistrict';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('dhcd_country_district.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}