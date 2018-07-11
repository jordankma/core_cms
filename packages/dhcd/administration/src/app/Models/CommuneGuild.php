<?php

namespace Dhcd\Administration\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class CommuneGuild extends Model {
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_commune_guild';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'commune_guild_id';

    protected $guarded = ['commune_guild_id'];
    protected $fillable = ['name'];

    public function getCountryDistrict(){
    	return $this->belongsTo('Dhcd\Administration\App\Models\CountryDistrict', 'country_district_id', 'country_district_id');
    }
}