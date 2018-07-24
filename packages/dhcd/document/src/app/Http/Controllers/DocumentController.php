<?php

namespace Dhcd\Document\App\Http\Controllers;

use Illuminate\Http\Request;
use Dhcd\Document\App\Repositories\DocumentRepository;
use Dhcd\Document\App\Repositories\DocumentTypeRepository;
use Dhcd\Document\App\Repositories\DocumentCateRepository;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Document\App\Models\Document;
use Dhcd\Document\App\Models\DocumentHasCate;
use Dhcd\Document\App\Models\DocumentType;
use Dhcd\Document\App\Models\DocumentCate;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Cache,Auth;

class DocumentController extends Controller
{
    
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    
    public function __construct(DocumentRepository $documentRepository, DocumentTypeRepository $documentTypeRepository, DocumentCateRepository $documentCateRepository) {
        parent::__construct();
        $this->documentRepository = $documentRepository;
        $this->documentCateRepository = $documentCateRepository;
        $this->documentTypeRepository = $documentTypeRepository;
    }
    
    public function manage(Request $request){                
        
        $cateObj = new DocumentCate();                             
        $cates = $this->documentCateRepository->getCates();
        $types = $this->documentTypeRepository->getTypes();
        
        $params = [];
        if(!empty($request->limit) || !empty($request->sort) || !empty($request->document_type_id) || !empty($request->document_cate_id) || !empty($request->name) || !empty($request->page)){
            $params=[
                'name' => $request->name,
                'document_type_id' => $request->document_type_id,
                'document_cate_id' => $request->document_cate_id,
                'limit' => $request->limit,
                'page' => $request->page,
                'sort' => $request->sort,
            ];
        }
        
        $documents = $this->documentRepository->getDocuments($params);        
        return view('DHCD-DOCUMENT::modules.document.doc.manage',compact('documents','params','request','types','cateObj','cates'));
    }
    
    public function add(Request $request){
        $cateObj = new DocumentCate();        
        $cates = $this->documentCateRepository->getCates();
        $types = $this->documentTypeRepository->getTypes();                
        return view('DHCD-DOCUMENT::modules.document.doc.add',compact('cates','types','cateObj'));
    }
    
    public function create(Request $request){
        
        if(empty($request->file_types) || empty($request->file_names)){
            return redirect()->back()->withInput()->withErrors(['Bạn chưa chọn file đính kèm']);
        }      
        $validator = Validator::make($request->all(), [
            'name' => 'required',            
            'descript' => 'required',
            'document_type_id' => 'required',            
        ]);
        if (!$validator->fails()) {            
             $files = [];
             $file_names = $request->file_names;
             $file_types = $request->file_types;
             
             foreach($file_names as $i => $name){
                 $files[] = [
                     'type' => $file_types[$i],
                     'name' => $name
                 ];
             }
             $type_control = !empty($request->type_control) ? $request->type_control : 'file';
             $avatar = '';
             if($type_control != 'file'){
                $avatar = !empty($request->setAvatar) ? $request->setAvatar : $files[0]['name'];                
             }
             
             $document = Document::create([
                 'name' => $request->name,
                 'descript' => $request->descript,
                 'alias' => $this->to_slug($request->name),
                 'document_type_id' => $request->document_type_id,
                 'file' => json_encode($files),
                 'avatar' => $avatar
             ]);
             if($document->document_id){
                  if (!empty($request->document_cate_id)) {    
                    $document_cate_id = $request->document_cate_id;
                    $dochascate = [];
                    foreach ($document_cate_id as $cate_id) {
                        $dochascate[] = [
                            'document_id' => $document->document_id,
                            'document_cate_id' => $cate_id
                        ];
                    }

                    if (!empty($dochascate)) {
                        DocumentHasCate::insert($dochascate);
                    }                 
                }
                
                activity('documents')->performedOn($document)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Add document - document: '.$document->document_id.', name: '.$document->name);
                return redirect()->route('dhcd.document.doc.add')->with('success','Thêm tài liệu thành công');
             }            
             return redirect()->back()->withInput()->withErrors(['Thêm tài liệu không thành công']);
             
        } else {
            
             return redirect()->back()->withInput()->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
        
    }
    
    public function edit(Request $request){
        $request->session()->put('document_file','multi');
        if(empty($request->only('document_id'))){
            return redirect()->route('dhcd.document.doc.manage')->withErrors(['Không tìm thấy tài liệu nào cần sửa']);
        }        
        $cateObj = new DocumentCate();
        
        $cates = $this->documentCateRepository->getCates();
        $types = $this->documentTypeRepository->getTypes();
        $document = $this->documentRepository->find($request->document_id);
        $cateIds = $this->_buildCateId($document->getDocumentCate->toArray());    
                
        return view('DHCD-DOCUMENT::modules.document.doc.edit',compact('document','types','cates','cateIds','cateObj'));
    }
    
    public function update(Request $request){
        
        if(empty($request->file_types) || empty($request->file_names)){
            return redirect()->back()->withInput()->withErrors(['Bạn chưa chọn file đính kèm']);
        }        
        
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'document_type_id' => 'required',
            'document_id' => 'required',
            'descript' => 'required',
        ]);
        
        if (!$validator->fails()) {
            
             $files = [];
             $file_names = $request->file_names;
             $file_types = $request->file_types;
             
             foreach($file_names as $i => $name){
                 $files[] = [
                     'type' => $file_types[$i],
                     'name' => $name
                 ];
             }
             $type_control = !empty($request->type_control) ? $request->type_control : 'file';
             $avatar = '';
             if($type_control == 'image'){
                $avatar = !empty($request->setAvatar) ? $request->setAvatar : $files[0]['name'];                
             }
            
             $document = $this->documentRepository->find($request->document_id);
             if($document->document_id){
                  $document->update([
                        'name' => $request->name,
                        'alias' => $this->to_slug($request->name),
                        'descript' => $request->descript,
                        'document_type_id' => $request->document_type_id,
                        'file' => json_encode($files),
                        'avatar' => $avatar
                  ]);
                  $document->save();
                  if (!empty($request->document_cate_id)) {    
                    $document_cate_id = $request->document_cate_id;
                    $dochascate = [];
                    foreach ($document_cate_id as $cate_id) {
                        $dochascate[] = [
                            'document_id' => $document->document_id,
                            'document_cate_id' => $cate_id
                        ];
                    }

                    if (!empty($dochascate)) {
                        DocumentHasCate::where('document_id',$document->document_id)->delete();
                        DocumentHasCate::insert($dochascate);
                    }                 
                }
                
                activity('documents')->performedOn($document)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Edit document - document: '.$document->document_type_id.', name: '.$document->name);
                return redirect()->route('dhcd.document.doc.manage')->with('success','Sửa tài liệu thành công');
        } else {            
             return redirect()->route('dhcd.document.doc.edit',['document_id' => $request->document_id])->withErrors(['Sửa tài liệu thành công']);
        }
        
        }
        else{
            return redirect()->route('dhcd.document.doc.edit',['document_id' => $request->document_id])->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
    }
    
    public function delete(Request $request){
        
        if(empty($request->only('document_id'))){
            return redirect()->route('dhcd.document.doc.manage')->withErrors(['Không tìm thấy tài liệu cần xóa']);
        }
        $document = $this->documentRepository->find($request->document_id);
        $document->status = 0;
        $document->deleted_at = date('Y-m-d H:s:i');        
        $document->save();
        
        activity('documents')->performedOn($document)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Delete document - document: '.$document->document_id.', name: '.$document->name);
        
        return redirect()->route('dhcd.document.doc.manage')->with('success','Xóa tài liệu thành công');
    }
    
    
    public function log(Request $request)
    {
        
        $model = 'documents';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->subject_id]
                ])->get();
                
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            ;
            return $validator->messages();
        }
    }
    
    protected function _buildCateId($cates){
        $data = [];
        foreach($cates as $cate){
            $data[] = $cate['document_cate_id'];
        }
        return $data;
    }
       
    protected function to_slug($str) {
        $str = trim(mb_strtolower($str));
        $str = preg_replace('/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/', 'a', $str);
        $str = preg_replace('/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/', 'e', $str);
        $str = preg_replace('/(ì|í|ị|ỉ|ĩ)/', 'i', $str);
        $str = preg_replace('/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/', 'o', $str);
        $str = preg_replace('/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/', 'u', $str);
        $str = preg_replace('/(ỳ|ý|ỵ|ỷ|ỹ)/', 'y', $str);
        $str = preg_replace('/(đ)/', 'd', $str);
        $str = preg_replace('/[^a-z0-9-\s]/', '', $str);
        $str = preg_replace('/([\s]+)/', '-', $str);
        return $str;
    }
                
}
