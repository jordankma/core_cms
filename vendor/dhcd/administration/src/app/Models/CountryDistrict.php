<?php

namespace Dhcd\Administration\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CountryDistrict extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_country_district';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'country_district_id';

    protected $guarded = ['country_district_id'];
    protected $fillable = ['name'];

    public function getProvineCity(){
    	return $this->belongsTo('Dhcd\Administration\App\Models\ProvineCity', 'provine_city_id', 'provine_city_id');
    }
}