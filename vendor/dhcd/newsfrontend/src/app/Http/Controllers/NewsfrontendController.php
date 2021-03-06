<?php

namespace Dhcd\Newsfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Dhcd\News\App\Repositories\NewsRepository;

use Dhcd\News\App\Models\News;

use Validator;

class NewsfrontendController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(NewsRepository $newsRepository)
    {
        parent::__construct();
        $this->news = $newsRepository;
    }
    
    public function list()
    {
        $list_news = News::paginate(15);
        $url_storage = config('site.url_storage');
        $data = [
            'list_news' => $list_news,
            'url_storage' => $url_storage
        ];
        return view('DHCD-NEWSFRONTEND::modules.newsfrontend.list',$data);
    }

    public function listCate(Request $request) {
        $validator = Validator::make($request->all(), [
            'news_cat_id' => 'required|numeric|min:1|max:50',
        ], $this->messages);
        if (!$validator->fails()) {
            $news_cat_id = $request->input('news_cat_id');
            $list_news = News::orderBy('news_id', 'desc')->with('getCats')
            ->whereHas('getCats', function ($query) use ($news_cat_id) {
                $query->where('dhcd_news_cat.news_cat_id', $news_cat_id);
            })->paginate(15);
            $url_storage = config('site.url_storage');
            $data = [
                'list_news' => $list_news,
                'url_storage' => $url_storage
            ];
            return view('DHCD-NEWSFRONTEND::modules.newsfrontend.list',$data);
        } else {
            return $validator->messages();
        }
    }
    public function detail(Request $request){
        $validator = Validator::make($request->all(), [
            'news_id' => 'required|numeric|min:1|max:50',
        ], $this->messages);
        if (!$validator->fails()) {
            $news_id = $request->input('news_id');
            $news = $this->news->find($news_id);
            if(!empty($news)){
                $data = [
                    'news' => $news
                ];
                return view('DHCD-NEWSFRONTEND::modules.newsfrontend.detail',$data);    
            }
            else{
                return 'false';
            }    
        }
        else{
            return $validator->messages();
        }
    }
}
