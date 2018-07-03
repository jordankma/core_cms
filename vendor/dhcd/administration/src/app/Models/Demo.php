<?php

namespace Dhcd\Administration\App\Models;

use Illuminate\Database\Eloquent\Model;

class Demo extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tbl_demo';

    protected $primaryKey = 'demo_id';

    protected $guarded = ['demo_id'];
    protected $fillable = ['name'];
}