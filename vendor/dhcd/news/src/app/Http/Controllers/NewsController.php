<?php

namespace Dhcd\News\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\News\App\Http\Requests\NewsCatRequest;
use Dhcd\News\App\Http\Requests\NewsRequest;

use Dhcd\News\App\Repositories\NewsRepository;
use Dhcd\News\App\Repositories\NewsCatRepository;
use Dhcd\News\App\Repositories\NewsTagRepository;
use Dhcd\News\App\Repositories\NewsHasTagRepository;
use Dhcd\News\App\Repositories\NewsHasCatRepository;

use Dhcd\News\App\Models\News;
use Dhcd\News\App\Models\NewsCat;
use Dhcd\News\App\Models\NewsTag;
use Dhcd\News\App\Models\NewsHasTag;
use Dhcd\News\App\Models\NewsHasCat;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
class NewsController extends Controller
{	
	private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

	public function __construct(NewsRepository $newsRepository, NewsCatRepository $newsCatRepository,NewsTagRepository $newsTagRepository,NewsHasTagRepository $newsHasTagRepository,NewsHasCatRepository $newsHasCatRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
        $this->news_cat = $newsCatRepository;
        $this->news_tag = $newsTagRepository;
        $this->news_has_tag = $newsHasTagRepository;
        $this->news_has_cat = $newsHasCatRepository;
        $this->_user = Auth::user();
    }
	/**
     * @return view list news
     * @author: tuanlv
     * @params: 
     * Chức năng : get list news
     */
	public function manager(Request $request){
		$list_news_cat = $this->news_cat->all();
		$params =[
    		'name'=>$request->name,
    		'news_time'=>$request->news_time,
    		'news_cat'=>$request->news_cat,
    		'is_hot'=> $request->is_hot
    	];
		return view('DHCD-NEWS::modules.news.news.manager',compact('list_news_cat','params'));
	}
	public function create(){
		$list_news_cat = $this->news_cat->all();
		return view('DHCD-NEWS::modules.news.news.create',compact('list_news_cat'));
	}
	public function add(NewsRequest $request){
		$user_id = $this->user->email;
		$title = $request->title;
		$news_cat = $request->news_cat;
		$news_tag = explode(",",$request->news_tag[0]);
		$title = $request->title;
		$title_alias = $request->title_alias;
		$desc = $request->desc;
		$content = $request->content;
		$image = $request->image;
		$is_hot = !empty($request->is_hot) ? $request->is_hot : 0;
		$priority = $request->priority;
		$desc_seo = !empty($request->desc_seo) ? $request->desc_seo : '';
		$filepath = $request->filepath;
		$key_word_seo = explode(",",$request->key_word_seo[0]);

		$news = new News();
		$news->user_id = $user_id;
		$news->title = $title;
		$news->news_cat = json_encode($news_cat);
		$news->news_tag = json_encode($news_tag);
		$news->title_alias = self::stripUnicode($title);
		$news->desc = $desc;
		$news->image = $filepath;
		$news->content = $content;
		$news->is_hot = $is_hot;
		$news->priority = $priority;
		$news->is_hot = $is_hot;
		$news->key_word_seo = json_encode($key_word_seo);
		$news->desc_seo = $desc_seo;
		$news->created_at = new DateTime();
		$news->updated_at = new DateTime();
		$news->save();

		if(!empty($news_tag)){
			foreach ($news_tag as $key => $tag) {
				$news_tag = new NewsTag();
				$news_tag->name = $tag;
				$news_tag->tag_alias = self::stripUnicode($tag);
				$news_tag->created_at = new DateTime();
				$news_tag->updated_at = new DateTime();
				$news_tag->save();
				$data_insert_news_has_tag[] =[
					'news_id'=> $news->news_id,
					'news_tag_id'=> $news_tag->news_tag_id
				];
				$list_tag_id[] = $news_tag->news_tag_id;
			}
			if(!empty($data_insert_news_has_tag)){
				DB::table('dhcd_news_has_tag')->insert($data_insert_news_has_tag);
				$news_tag_list = NewsTag::whereIn('news_tag_id', $list_tag_id)->select('news_tag_id', 'name')->get()->toJson();
	            $news->news_tag = $news_tag_list;
	            $news->save();
			}
		}
		if (!empty($news_cat)) {
            $news_has_tag = [];
            foreach ($news_cat as $cat) {
                $news_has_tag[] = [
                    'news_id' => $news->news_id,
                    'news_cat_id' => $cat
                ];
            }
            if (!empty($news_has_tag)) {
                DB::table('dhcd_news_has_cat')->insert($news_has_tag);
            }
            $news_cat_list = NewsCat::whereIn('news_cat_id', $news_cat)->select('news_cat_id', 'name')->get()->toJson();
            $news->news_cat = $news_cat_list;
            $news->save();
        }
		if ($news->news_id) {
            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add news - name: :properties.name, news_id: ' . $news->news_id);
            return redirect()->route('dhcd.news.news.manager')->with('success', trans('DHCD-NEWS::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.news.news.manager')->with('error', trans('DHCD-NEWS::language.messages.error.create'));
        }
	}
	public function show($news_id){
		$list_news_cat = $this->news_cat->all();
		$news = $this->news->find($news_id);
		$list_id_cat = [];
		$list_tag = [];
		if(!empty($news->news_cat)){
			$news_cat = json_decode($news->news_cat,true);
			foreach ($news_cat as $key => $value) {
				$list_id_cat[] = $value['news_cat_id'];
			} 
		}
		if(!empty($news->news_tag)){
			$news_tag = json_decode($news->news_tag,true);
			foreach ($news_tag as $key => $value) {
				$list_tag[] = $value['name'];
			}	
		}
		$list_tag_string = implode(',', $list_tag);
		$list_key_word_seo_string = implode(',', json_decode($news->key_word_seo,true));
		return view('DHCD-NEWS::modules.news.news.edit',compact('news','list_id_cat','list_tag_string','list_news_cat','list_key_word_seo_string'));
	}	
	public function update($news_id,NewsRequest $request){
		$list_tag_id_old = NewsHasTag::where('news_id',$news_id)->select('news_tag_id') ->get()->toArray();
		DB::table('dhcd_news_tag')->whereIn('news_tag_id',$list_tag_id_old)->delete();
		DB::table('dhcd_news_has_tag')->where('news_id',$news_id)->delete();
		DB::table('dhcd_news_has_cat')->where('news_id',$news_id)->delete();

		$user_id = $this->user->user_id;
		$title = $request->title;
		$news_cat = $request->news_cat;
		$news_tag = explode(",",$request->news_tag[0]);
		$title = $request->title;
		$title_alias = $request->title_alias;
		$desc = $request->desc;
		$content = $request->content;
		$image = $request->image;
		$filepath = $request->filepath;
		$is_hot = $request->is_hot;
		$priority = $request->priority;
		$desc_seo = !empty($request->desc_seo) ? $request->desc_seo : '';
		$key_word_seo = explode(",",$request->key_word_seo[0]);

		$news = $this->news->find($news_id);
		$news->user_id = $user_id;
		$news->title = $title;
		$news->news_cat = json_encode($news_cat);
		$news->news_tag = json_encode($news_tag);
		$news->title_alias = self::stripUnicode($title);
		$news->desc = $desc;
		$news->content = $content;
		$news->image = $filepath;
		$news->is_hot = $is_hot;
		$news->priority = $priority;
		$news->is_hot = $is_hot;
		$news->key_word_seo = json_encode($key_word_seo);
		$news->desc_seo = $desc_seo;
		$news->updated_at = new DateTime();
		$news->save();

		if(!empty($news_tag)){
			foreach ($news_tag as $key => $tag) {
				$news_tag = new NewsTag();
				$news_tag->name = $tag;
				$news_tag->tag_alias = self::stripUnicode($tag);
				$news_tag->created_at = new DateTime();
				$news_tag->updated_at = new DateTime();
				$news_tag->save();
				$data_insert_news_has_tag[] =[
					'news_id'=> $news->news_id,
					'news_tag_id'=> $news_tag->news_tag_id
				];
				$list_tag_id[] = $news_tag->news_tag_id;
			}
			if(!empty($data_insert_news_has_tag)){
				DB::table('dhcd_news_has_tag')->insert($data_insert_news_has_tag);
				$news_tag_list = NewsTag::whereIn('news_tag_id', $list_tag_id)->select('news_tag_id', 'name')->get()->toJson();
	            $news->news_tag = $news_tag_list;
	            $news->save();
			}
		}
		if (!empty($news_cat)) {
            $news_has_tag = [];
            foreach ($news_cat as $cat) {
                $news_has_tag[] = [
                    'news_id' => $news->news_id,
                    'news_cat_id' => $cat
                ];
            }
            if (!empty($news_has_tag)) {
                DB::table('dhcd_news_has_cat')->insert($news_has_tag);
            }
            $news_cat_list = NewsCat::whereIn('news_cat_id', $news_cat)->select('news_cat_id', 'name')->get()->toJson();
            $news->news_cat = $news_cat_list;
            $news->save();
        }
		if ($news->news_id) {
            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Edit news - name: :properties.name, news_id: ' . $news->news_id);
            return redirect()->route('dhcd.news.news.manager')->with('success', trans('DHCD-NEWS::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.news.news.manager')->with('error', trans('DHCD-NEWS::language.messages.error.create'));
        }		
	}
	public function postAddImages(){
		$y = date('Y');
	    $m = date('m');
	    $CKEditor = Input::get('CKEditor');
	    $funcNum = Input::get('CKEditorFuncNum');
	    $message = $url = '';
	    if (Input::hasFile('upload')) {
	        $file = Input::file('upload');
	        if ($file->isValid()) {
	            $path = "uploads/media/news/images/$y/$m/";
	            $path_media = "uploads/media/news/images/$y/$m/";
	            //$file_extension = $file->extension();
	            $originalName = $file->getClientOriginalName();
	            $tmp = explode('.', $originalName);
	            $file_extension = end($tmp);
	            $filename = self::stripUnicode('Image') . '-' . time() . "." . $file_extension;
	          
	            $file->move($path, $filename);
	            $url = URL::to('').'/'.$path . $filename;
	        } 
	        else{
	        	$message = 'An error occured while uploading the file.';
	        }
	    }
	    else{
	    	$message = 'No file uploaded.';
	    }
	    return '<script>window.parent.CKEDITOR.tools.callFunction('.$funcNum.', "'.$url.'", "'.$message.'")</script>';
	}
	public function log(Request $request)
    {
        $model = 'news';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'news_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('news_id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
    public function delete(Request $request)
    {
        $news_id = $request->news_id;
        $news = $this->news->find($news_id);
        if (null != $news) {
            $news->visible = 0;
            $news->save();
            activity('news')
                ->performedOn($news)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete News Cat - news_id: :properties.news_id, name: ' . $news->name);
            return redirect()->route('dhcd.news.news.manager')->with('success', trans('DHCD-NEWS::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.news.news.manager')->with('error', trans('DHCD-NEWS::language.messages.error.delete'));
        }
    }
    public function getModalDelete(Request $request)
    {
        $model = 'news';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'news_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.news.news.delete', ['news_id' => $request->news_id]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }
	//Table Data to index page
    public function data(Request $request)
    {
    	$params =[
    		'name'=>$request->name,
    		'news_time'=>$request->news_time,
    		'news_cat'=>$request->news_cat,
    		'is_hot'=> $request->is_hot
    	];
    	if($request->name!=null || $request->news_time!=null || $request->news_cat!=null || $request->is_hot!=null){
    		$list_news = News::getListNews($params);
    	}
    	else{
    		$list_news = News::where('visible',1)->get();	
    	}
        return Datatables::of($list_news)
            ->addColumn('actions', function ($list_news) {
                $actions = '<a href=' . route('dhcd.news.news.log', ['type' => 'news', 'news_id' => $list_news->news_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log news cat"></i></a>
                        <a href=' . route('dhcd.news.news.show', ['news_id' => $list_news->news_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update news cat"></i></a>
                        <a href=' . route('dhcd.news.news.confirm-delete', ['news_id' => $list_news->news_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete news cat"></i></a>';

                return $actions;
            })
            ->addColumn('title', function ($list_news) {
            	if($list_news->is_hot==1){
            		$title = $list_news->title . '  (Tin hot)';
            	}
            	else{
            		$title = $list_news->title;	
            	}
            	return $title;
            })
            ->addColumn('image', function ($list_news) {
            	$image = '<img src="'.$list_news->image.'"  height="80" width="100">';
            	return $image;
            })
            ->addColumn('news_cat', function ($list_news) {
            	$list_cat_json = json_decode($list_news->news_cat,true);
            	$list_cat_array = array();
            	foreach ($list_cat_json as $key => $cat) {
            		$list_cat_array[] = $cat['name'];	
            	}
            	$news_cat = implode(",",$list_cat_array);
            	return $news_cat;
            })
            ->rawColumns(['actions','is_hot','image'])
            ->make();
    }
    public function searchNews(){
    	$list_news_cat = $this->news_cat->all();
		return view('DHCD-NEWS::modules.news.news.manager_search',compact('list_news_cat'));
    }
}