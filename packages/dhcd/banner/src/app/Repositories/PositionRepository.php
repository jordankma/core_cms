<?php

namespace Dhcd\Banner\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\Banner\Repositories
 */
class PositionRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Banner\App\Models\Position';
    }

}
