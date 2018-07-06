<?php

namespace Dhcd\Member\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model {
	use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_member';

    protected $primaryKey = 'member_id';

    protected $guarded = ['member_id'];
    protected $fillable = ['name'];
}