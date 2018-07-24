<?php

namespace Dhcd\Document\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Dhcd\Document\App\Models\DocumentCate;
use Cache;
/**
 * Class DemoRepository
 * @package Dhcd\Document\Repositories
 */
class DocumentCateRepository extends Repository
{

    /**
     * @return string
     */
    public function model()
    {
        return 'Dhcd\Document\App\Models\DocumentCate';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }
    
    public function getCates(){
        Cache::forget('document_cates_list');
        if(Cache::has('document_cates_list')){            
            $cates = Cache::get('document_cates_list');            
            return $cates;            
        } else {
            $cates = DocumentCate::orderBy('document_cate_id','desc')->get()->toArray();
            $data = [];
            if($cates){
                Cache::forever('document_cates_list',$cates);
                $data = $cates;                
            }
            return $data;
        }        
    }
    
}
