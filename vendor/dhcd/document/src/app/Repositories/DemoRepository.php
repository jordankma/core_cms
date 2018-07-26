<?php

namespace Dhcd\Document\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Document\Repositories
 */
class DemoRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Document\App\Models\Demo';
    }

    public function findAll() {

        $result = $this->model::all();
        dd($result);die;
    }
}
