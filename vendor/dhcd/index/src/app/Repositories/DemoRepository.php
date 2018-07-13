<?php

namespace Dhcd\Index\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Index\Repositories
 */
class DemoRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Index\App\Models\Demo';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
