<?php

namespace Dhcd\Notification\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;

/**
 * Class DemoRepository
 * @package Dhcd\Notification\Repositories
 */
class NotificationRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Notification\App\Models\Notification';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
}
