<?php

namespace Dhcd\Document\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Document\App\Models\DocumentType;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Cache,Auth;

class DocumentTypeController extends Controller
{
    
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );
    
    public function __construct() {
        parent::__construct();
        
    }
    
    public function manage(Request $request){                
        $objType = new DocumentType();
        $types = $objType->getTypes();        
        return view('DHCD-DOCUMENT::modules.document.type.manage',compact('types'));
    }
    
    public function add(Request $request){                      
        return view('DHCD-DOCUMENT::modules.document.type.add');
    }
    
    public function create(Request $request){
                       
        $validator = Validator::make($request->all(), [
            'name' => 'required'            
        ], $this->messages);
        if (!$validator->fails()) {
             $type = DocumentType::create($request->all());
             if($type->document_type_id){
                  $this->resetCache();
                  activity('document_types')->performedOn($type)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Add document type - document_type: '.$type->document_type_id.', name: '.$type->name);
                  return redirect()->route('dhcd.document.type.add')->with('success','Thêm kiểu tài liệu thành công');
             }            
             return redirect()->route('dhcd.document.type.add')->withErrors(['Thêm kiểu tài liệu không thành công']);
             
        } else {
            
             return redirect()->route('dhcd.document.type.add')->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
        
    }
    
    public function edit(Request $request){
        if(empty($request->only('document_type_id'))){
            return redirect()->route('dhcd.document.type.manage')->withErrors(['Không tìm thấy kiểu tài liệu nào cần sửa']);
        }        
        $type = DocumentType::findOrFail($request->document_type_id);
        return view('DHCD-DOCUMENT::modules.document.type.edit',compact('type'));
    }
    
    public function update(Request $request){
                
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'document_type_id' => 'required'
        ]);
        if (!$validator->fails()) {
             $type = DocumentType::findOrFail($request->document_type_id);
             $type->name = $request->name;
             
             if(!empty($request->icon)){
                 $type->icon = $request->icon;
             }
             $type->save();
            
             $this->resetCache();
             activity('document_types')->performedOn($type)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Edit document type - document_type: '.$type->document_type_id.', name: '.$type->name);
             return redirect()->route('dhcd.document.type.manage')->with('success','Cập nhật kiểu tài liệu thành công');                                                
        } else {            
             return redirect()->route('dhcd.document.type.edit',['document_type_id' => $request->document_type_id])->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
        
    }
    
    public function delete(Request $request){
        
        if(empty($request->only('document_type_id'))){
            return redirect()->route('dhcd.document.type.manage')->withErrors(['Không tìm thấy danh mục cần xóa']);
        }
        $type = DocumentType::findOrFail($request->document_type_id);
        $type->status = 0;
        
        $type->save();
        
        activity('document_type')->performedOn($type)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Delete document type - document_type: '.$type->document_type_id.', name: '.$type->name);
        $this->resetCache();
        return redirect()->route('dhcd.document.type.manage')->with('success','Xóa kiểu tài liệu thành công');
    }
    
    
    
    public function resetCache(){
        Cache::forget('list_type');
    }
                
}