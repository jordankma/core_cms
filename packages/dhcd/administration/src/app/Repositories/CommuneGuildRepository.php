<?php

namespace Dhcd\Administration\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\Administration\Repositories
 */
class CommuneGuildRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Administration\App\Models\CommuneGuild';
    }
}