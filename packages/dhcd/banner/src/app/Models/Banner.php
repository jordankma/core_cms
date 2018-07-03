<?php

namespace Dhcd\Banner\App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_banner';

    protected $primaryKey = 'banner_id';

    protected $guarded = ['banner_id'];
    protected $fillable = ['name'];
}