<?php

namespace Dhcd\Administration\App\Models;

use Illuminate\Database\Eloquent\Model;

class ProvineCity extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_provine_city';

    protected $primaryKey = 'provine_city_id';

    protected $guarded = ['provine_city_id'];
    protected $fillable = ['name'];
}