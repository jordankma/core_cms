<?php

namespace Dhcd\Document\App\Models;

use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DocumentCate extends Model {
    use SoftDeletes;
    protected $_html;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'document_cates';

    protected $primaryKey = 'document_cate_id';

    protected $fillable = ['name','parent_id','icon'];
    
    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    
    
    public function getCates(){
        
        if(Cache::has('list_cate')){            
            $cates = Cache::get('list_cate');            
            return $cates;            
        } else {
            $cates = DocumentCate::where('status',1)->get()->toArray();
            $data = [];
            if($cates){
                Cache::forever('list_cate',$cates);
                $data = $cates;                
            }
            return $data;
        }        
    }
    
    public static function showCategories($cates,$parent_current = 0,$prarent_id = 0, $char = ''){
             
        foreach($cates as $key => $item){
            if($item['parent_id'] == $prarent_id){
                if($item['document_cate_id'] == $parent_current )
                {
                    echo  '<option value="'.$item['document_cate_id'].'" selected>'.$char.' '.$item['name'].'</option>';                
                }
                else{
                    echo  '<option value="'.$item['document_cate_id'].'" >'.$char.' '.$item['name'].'</option>';  
                }
                unset($cates[$key]);
                self::showCategories($cates,$parent_current,$item['document_cate_id'],$char.'|--');
            }
        }
       
    }
}
