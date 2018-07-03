<?php

namespace Adtech\Core\App\Models;

use Illuminate\Database\Eloquent\Model;
use \Adtech\Application\Cms\Libraries\Acl as AdtechAcl;

class Api extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_core';

    protected $table = 'adtech_core_api';

    protected $primaryKey = 'api_id';

    protected $fillable = ['package_id', 'name', 'link', 'description', 'datademo', 'status'];
}
