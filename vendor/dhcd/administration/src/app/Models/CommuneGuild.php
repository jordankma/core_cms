<?php

namespace Dhcd\Administration\App\Models;

use Illuminate\Database\Eloquent\Model;

class CommuneGuild extends Model {
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'dhcd_commune_guild';

    protected $primaryKey = 'commune_guild_id';

    protected $guarded = ['commune_guild_id'];
    protected $fillable = ['name'];

    public function getCountryDistrict(){
    	return $this->belongsTo('Dhcd\Administration\App\Models\CountryDistrict', 'parent_code', 'code');
    }
}