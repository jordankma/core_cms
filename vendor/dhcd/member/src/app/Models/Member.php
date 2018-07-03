<?php

namespace Dhcd\Member\App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model {
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