<?php

namespace Dhcd\Document\App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentType extends Model {
    //use SoftDeletes;
    protected $_html;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'document_types';

    protected $primaryKey = 'document_type_id';

    protected $fillable = ['name','icon','status'];
    
    public $timestamps = true;
    
    
    public function getTypes(){
        
        if(Cache::has('list_type')){            
            $types = Cache::get('list_type');            
            return $types;            
        } else {
            $types = DocumentType::where('status',1)->get()->toArray();
            $data = [];
            if($types){
                Cache::forever('list_type',$types);
                $data = $types;                
            }
            return $data;
        }        
    }
    
    
}
