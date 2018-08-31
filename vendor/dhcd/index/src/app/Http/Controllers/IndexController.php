<?php

namespace Dhcd\Index\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Dhcd\News\App\Repositories\NewsRepository;

use Dhcd\News\App\Models\News;
use Dhcd\Events\App\Models\Events;

use Validator;

class IndexController extends Controller
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
    
    public function index()
    {
        $list_news = News::paginate(10);
        $list_events = Events::all();
        $url_storage = config('site.url_storage');
        $data = [
            'list_news' => $list_news,
            'list_events' => $list_events,
            'url_storage' => $url_storage
        ];
        return view('DHCD-INDEX::modules.index.index',$data);
    }
}
