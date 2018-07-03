<?php

namespace Dhcd\Member\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\Member\Repositories
 */
class MemberRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Member\App\Models\Member';
    }

    public function deleteID($id) {
        return $this->model->where('member_id', '=', $id)->update(['visible' => 0]);
    }
}
