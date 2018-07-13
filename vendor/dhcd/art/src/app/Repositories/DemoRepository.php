<?php

namespace Dhcd\Art\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Art\Repositories
 */
class DemoRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Art\App\Models\Demo';
    }

    public function findAll() {

        DB::statement(DB::raw('set @rownum=0'));
        $result = $this->model::query();
        $result->select('tbl_demo.*', DB::raw('@rownum  := @rownum  + 1 AS rownum'));

        return $result;
    }
}
