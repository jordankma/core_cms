<?php

namespace Dhcd\Filedoc\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Document\App\Repositories\DocumentRepository;
use Dhcd\Document\App\Repositories\DocumentCateRepository;
use File,
    Storage;

class FileDocumentController extends Controller {

    public function __construct(DocumentRepository $documentRepository, DocumentCateRepository $documentCateRepository) {
        parent::__construct();
        $this->documentRepository = $documentRepository;
        $this->documentCateRepository = $documentCateRepository;
    }

    public function getFileDocument(Request $request) {

        $params = [];
        $cate = [];
        $document_cate_id = null;
        if (!empty($request->alias_cate)) {
            $cate = $this->documentCateRepository->findBy('alias', $request->alias_cate);
            if (!empty($cate)) {
                $document_cate_id = $cate->document_cate_id;

                if (!empty($request->limit) || !empty($request->sort) || !empty($request->document_type_id) || !empty($request->document_cate_id) || !empty($document_cate_id) || !empty($request->page)) {
                    $params = [
                        'name' => $request->name,
                        'document_type_id' => $request->document_type_id,
                        'document_cate_id' => $document_cate_id,
                        'limit' => $request->limit,
                        'page' => $request->page,
                        'sort' => $request->sort,
                    ];
                }
                $documents = $this->documentRepository->getDocuments($params);
                return view('DHCD-FILEDOC::modules.filedoc.list', compact('documents', 'params', 'request', 'cate'));
            } else {
                return redirect()->back()->withErrors(['Không tìm thấy tài liệu']);
            }
        } else {
            return redirect()->back()->withErrors(['Không tìm thấy tài liệu']);
        }
    }

    public function DocumentDetail(Request $request) {
        if (!empty($request->alias_cate) && !empty($request->alias)) {
            $cate = $this->documentCateRepository->findBy('alias', $request->alias_cate);
            if ($cate) {
                $params = [
                    'document_cate_id' => $cate->document_cate_id,
                    'alias' => $request->alias
                ];
                $document = $this->documentRepository->findDocument($params);
                if ($document) {
                    return view('DHCD-FILEDOC::modules.filedoc.detail', compact('document', 'alias_cate'));
                } else {
                    return redirect()->back()->withErrors(['Không tìm thấy tài liệu']);
                }
            } else {
                return redirect()->back()->withErrors(['Không tìm thấy tài liệu']);
            }
        } else {
            return redirect()->back()->withErrors(['Không tìm thấy tài liệu']);
        }
    }

}
