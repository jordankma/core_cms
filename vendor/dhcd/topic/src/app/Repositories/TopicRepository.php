<?php

namespace Dhcd\Topic\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\Topic\Repositories
 */
class TopicRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Topic\App\Models\Topic';
    }

    public function deleteID($id) {
        return $this->model->where('topic_id', '=', $id)->update(['visible' => 0]);
    }
}
