<?php

namespace Adtech\Core\App\Models;

use Illuminate\Database\Eloquent\Model;
use \Adtech\Application\Cms\Libraries\Acl as AdtechAcl;

class Menu extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $connection = 'mysql_core';

    protected $table = 'adtech_core_menus';

    protected $primaryKey = 'menu_id';

    protected $fillable = ['parent', 'name', 'route_name', 'domain_id', 'group'];

    public function domains()
    {
        return $this->hasMany('Adtech\Core\App\Models\Domain');
    }
}
