<?php

namespace Dhcd\Banner\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\Banner\Repositories
 */
class BannerRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Banner\App\Models\Banner';
    }

    public function deleteID($id) {
        return $this->model->where('banner_id', '=', $id)->update(['visible' => 0]);
    }
}
