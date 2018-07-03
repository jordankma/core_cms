<?php

namespace Dhcd\Member\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\Member\Repositories
 */
class DemoRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Member\App\Models\Demo';
    }

    public function deleteID($id) {
        return $this->model->where('demo_id', '=', $id)->update(['visible' => 0]);
    }
}
