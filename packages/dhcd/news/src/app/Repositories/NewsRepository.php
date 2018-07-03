<?php

namespace Dhcd\News\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;

/**
 * Class DemoRepository
 * @package Dhcd\News\Repositories
 */
class NewsRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\News\App\Models\News';
    }
    
}