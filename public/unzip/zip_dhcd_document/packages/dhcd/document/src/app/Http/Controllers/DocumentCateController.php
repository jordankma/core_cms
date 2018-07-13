<?php

namespace Dhcd\Document\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Document\App\Models\DocumentCate;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Cache,Auth;

class DocumentCateController extends Controller
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
        $objCate = new DocumentCate();
        $cates = $this->_buildCate($objCate->getCates());        
        return view('DHCD-DOCUMENT::modules.document.cate.manage',compact('cates'));
    }
    
    public function add(Request $request){
        
        $objCate = new DocumentCate();
        $cates = $objCate->getCates();
       
        return view('DHCD-DOCUMENT::modules.document.cate.add',compact('cates','objCate'));
    }
    
    public function create(Request $request){
                       
        $validator = Validator::make($request->all(), [
            'name' => 'required'            
        ], $this->messages);
        if (!$validator->fails()) {
             $cate = DocumentCate::create($request->all());
             if($cate->document_cate_id){
                  $this->resetCache();
                  activity('document_cates')->performedOn($cate)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Add document cate - document_cate: '.$cate->document_cate_id.', name: '.$cate->name);
                  return redirect()->route('dhcd.document.cate.add')->with('success','Thêm danh mục thành công');
             }            
             return redirect()->route('dhcd.document.cate.add')->withErrors(['Thêm danh mục không thành công']);
             
        } else {
            
             return redirect()->route('dhcd.document.cate.add')->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
        
    }
    
    public function edit(Request $request){
        if(empty($request->only('document_cate_id'))){
            return redirect()->route('dhcd.document.cate.manage')->withErrors(['Không tìm thấy danh mục cần sửa']);
        }
        $objCate = new DocumentCate();
        $cates = $objCate->getCates();
        $cate = DocumentCate::findOrFail($request->document_cate_id);
        return view('DHCD-DOCUMENT::modules.document.cate.edit',compact('cate','cates','objCate'));
    }
    
    public function update(Request $request){
                
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'document_cate_id' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
             $cate = DocumentCate::findOrFail($request->document_cate_id);
             $cate->name = $request->name;
             if($cate->parent_id != $request->parent_id)
             {  
                 $cate->parent_id = $request->parent_id;             
             }
             if(!empty($request->icon)){
                 $cate->icon = $request->icon;
             }
             $cate->save();
            
             $this->resetCache();
             activity('document_cates')->performedOn($cate)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Edit document cate - document_cate: '.$cate->document_cate_id.', name: '.$cate->name);
             return redirect()->route('dhcd.document.cate.manage')->with('success','Cập nhật danh mục thành công');                                                
        } else {            
             return redirect()->route('dhcd.document.cate.edit',['document_cate_id' => $request->document_cate_id])->withErrors(['Vui lòng kiểm tra lại dữ liệu nhập vào']);
        }
        
    }
    
    public function delete(Request $request){
        
        if(empty($request->only('document_cate_id'))){
            return redirect()->route('dhcd.document.cate.manage')->withErrors(['Không tìm thấy danh mục cần xóa']);
        }
        $cate = DocumentCate::findOrFail($request->document_cate_id);
        $cate->status = 0;
        $cate->deleted_at = date('Y-m-d H:s:i');
        $cate->save();
        
        activity('document_cates')->performedOn($cate)->withProperties($request->all())->log('User: :'.Auth::user()->email.' - Delete document cate - document_cate: '.$cate->document_cate_id.', name: '.$cate->name);
        $this->resetCache();
        return redirect()->route('dhcd.document.cate.manage')->with('success','Xóa danh mục thành công');
    }
    
    
    
    public function resetCache(){
        Cache::forget('list_cate');
    }
    
    protected function _buildCate($cates){
        $datas = [];
        foreach($cates as $cate){
            $datas[$cate['document_cate_id']] = [
                'name' => $cate['name'],
                'icon' => $cate['icon'],
                'parent_id' => $cate['parent_id']                
            ];
        }
        return $datas;
    }
    
    
}