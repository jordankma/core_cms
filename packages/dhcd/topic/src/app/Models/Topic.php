<?php

namespace Dhcd\Topic\App\Models;

use Illuminate\Database\Eloquent\Model;

class Topic extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_topic';

    protected $primaryKey = 'topic_id';

    protected $guarded = ['topic_id'];
    protected $fillable = ['name'];
}