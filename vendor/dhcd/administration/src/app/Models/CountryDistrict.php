<?php

namespace Dhcd\Administration\App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryDistrict extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_country_district';

    protected $primaryKey = 'country_district_id';

    protected $guarded = ['country_district_id'];
    protected $fillable = ['name'];

    public function getProvineCity(){
    	return $this->belongsTo('Dhcd\Administration\App\Models\ProvineCity', 'parent_code', 'code');
    }
}