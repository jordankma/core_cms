<?php

namespace Dhcd\Topic\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Topic\App\Repositories\TopicRepository;
use Dhcd\Topic\App\Models\Topic;
use Dhcd\Topic\App\Models\TopicHasMember;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;

class TopicController extends Controller
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

    public function manage()
    {
        return view('DHCD-TOPIC::modules.topic.topic.manage');
    }

    public function create()
    {
        return view('DHCD-TOPIC::modules.topic.topic.create');
    }
    
    public function add(Request $request)
    {
        $topics = new Topic($request->all());
        $topics->save();

        if ($topics->topic_id) {

            activity('topic')
                ->performedOn($topics)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add topic - name: :properties.name, topic_id: ' . $topics->topic_id);

            return redirect()->route('dhcd.topic.topic.manage')->with('success', trans('dhcd-topic::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.topic.topic.manage')->with('error', trans('dhcd-topic::language.messages.error.create'));
        }
    }

    public function show(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $topic = $this->topic->find($topic_id);
        $data = [
            'topic' => $topic
        ];

        return view('DHCD-TOPIC::modules.topic.topic.edit', $data);
    }

    public function update(Request $request)
    {
        $topic_id = $request->input('topic_id');

        $topic = $this->topic->find($topic_id);
        $topic->name = $request->input('name');

        if ($topic->save()) {

            activity('topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update topic - topic_id: :properties.topic_id, name: :properties.name');

            return redirect()->route('dhcd.topic.topic.manage')->with('success', trans('dhcd-topic::language.messages.success.update'));
        } else {
            return redirect()->route('dhcd.topic.topic.show', ['topic_id' => $request->input('topic_id')])->with('error', trans('dhcd-topic::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'topic';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.topic.topic.delete', ['topic_id' => $request->input('topic_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $topic = $this->topic->find($topic_id);

        if (null != $topic) {
            $this->topic->deleteID($topic_id);

            activity('topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete topic - topic_id: :properties.topic_id, name: ' . $topic->name);

            return redirect()->route('dhcd.topic.topic.manage')->with('success', trans('dhcd-topic::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.topic.topic.manage')->with('error', trans('dhcd-topic::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'topic';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        $topics = Topic::where('visible',1)->get();
        return Datatables::of($topics)
            ->addColumn('actions', function ($topics) {
                $actions = '<a href=' . route('dhcd.topic.topic.log', ['type' => 'topic', 'id' => $topics->topic_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log topic"></i></a>
                        <a href=' . route('dhcd.topic.topic.show', ['topic_id' => $topics->topic_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update topic"></i></a>
                        <a href=' . route('dhcd.topic.topic.confirm-delete', ['topic_id' => $topics->topic_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete topic"></i></a>';

                return $actions;
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
