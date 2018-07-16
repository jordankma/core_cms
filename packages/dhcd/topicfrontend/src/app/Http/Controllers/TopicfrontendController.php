<?php

namespace Dhcd\Topicfrontend\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Dhcd\Topic\App\Repositories\TopicRepository;
use Dhcd\Topic\App\Models\TopicHasMember;
use Dhcd\Topic\App\Models\Topic;

use Validator;

class TopicfrontendController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(TopicRepository $topicRepository)
    {
        parent::__construct();
        $this->topic = $topicRepository;
    }

    public function list(){
        $url_storage = config('site.url_storage');
        $member_id = $this->user->member_id;
        //list topic thuoc member
        $list_topic_id_tmp = $list_topic_id = array();
        $list_topic_id_tmp = TopicHasMember::where('member_id', $member_id)->select('topic_id')->get();
        if(count($list_topic_id_tmp) > 0){
            foreach ($list_topic_id_tmp as $key1 => $value1) {
                $list_topic_id[] = $value1->topic_id;
            }
        }
        $list_topics = Topic::where('status',1)->paginate(10);
        $data = [
            "list_topic_id" => $list_topic_id,
            "list_topics" => $list_topics,
            'url_storage' => $url_storage
        ];
        return view('DHCD-TOPICFRONTEND::modules.topicfrontend.list',$data);
    }

    public function detail(){
        return view('DHCD-TOPICFRONTEND::modules.topicfrontend.detail');
    }

}
