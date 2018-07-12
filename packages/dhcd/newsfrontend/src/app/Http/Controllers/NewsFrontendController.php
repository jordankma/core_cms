<?php

namespace Dhcd\NewsFrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Dhcd\News\App\Repositories\NewsRepository;

use Dhcd\News\App\Models\News;

use Validator;

class NewsFrontendController extends Controller
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
        $list_news = News::paginate(10);
        $data = [
            'list_news' => $list_news
        ];
        return view('DHCD-NEWSFRONTEND::modules.newsfrontend.list',$data);
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
