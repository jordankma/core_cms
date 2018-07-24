<?php

namespace Dhcd\Document\App\Repositories;

use Adtech\Application\Cms\Repositories\Eloquent\Repository;
use Illuminate\Support\Facades\DB;
use Dhcd\Document\App\Models\Document;
use Cache;

/**
 * Class DemoRepository
 * @package Dhcd\Document\Repositories
 */
class DocumentRepository extends Repository {

    /**
     * @return string
     */
    public function model() {
        return 'Dhcd\Document\App\Models\Document';
    }

    public function findAll() {

        $result = $this->model::query();
        return $result;
    }

    public function getDocuments($params) {
        $limit = !empty($params['limit']) ? $params['limit'] : 10;
        $sort = !empty($params['sort']) ? $params['sort'] : 'desc';

        $query = Document::select('package_documents.*')->with('getType', 'getDocumentCate')->orderBy('document_id', $sort);
        if (!empty($params['name'])) {
            $query->where('name', $params['name']);
        }
        if (!empty($params['document_type_id'])) {
            $query->where('document_type_id', $params['document_type_id']);
        }
        if (!empty($params['document_cate_id'])) {
            $query->join('package_document_has_cate', 'package_documents.document_id', '=', 'package_document_has_cate.document_id')->where('document_cate_id', $params['document_cate_id']);
        }
        $data = [];
        $documents = $query->paginate($limit);
        if ($documents) {
            Cache::forever('list_document', $documents);
            $data = $documents;
        }
        return $data;
    }

    public function findDocument($params){
        $data = [];
        $query = Document::select('package_documents.*')->with('getType', 'getDocumentCate');
        if (!empty($params['name'])) {
            $query->where('name', $params['name']);
        }
        if (!empty($params['document_type_id'])) {
            $query->where('document_type_id', $params['document_type_id']);
        }
        if (!empty($params['alias'])) {
            $query->where('package_documents.alias', $params['alias']);
        }       
        if (!empty($params['document_cate_id'])) {
            $query->join('package_document_has_cate', 'package_documents.document_id', '=', 'package_document_has_cate.document_id')->where('document_cate_id', $params['document_cate_id']);
        }
        
        $data = $query->first();
        return $data;
    }
    
}
