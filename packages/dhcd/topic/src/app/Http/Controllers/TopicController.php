<?php

namespace Dhcd\Topic\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;

use Dhcd\Topic\App\Http\Requests\TopicRequest;

use Dhcd\Topic\App\Repositories\TopicRepository;
use Dhcd\Member\App\Repositories\MemberRepository;

use Dhcd\Topic\App\Models\Topic;
use Dhcd\Topic\App\Models\TopicHasMember;
use Dhcd\Member\App\Models\Member;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime,DB;

class TopicController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(TopicRepository $topicRepository,MemberRepository $memberRepository)
    {
        parent::__construct();
        $this->topic = $topicRepository;
        $this->member = $memberRepository;
    }

    public function manage()
    {
        return view('DHCD-TOPIC::modules.topic.topic.manage');
    }

    public function create()
    {
        return view('DHCD-TOPIC::modules.topic.topic.create');
    }
    
    public function add(TopicRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            $topics = new Topic();
            $topics->name = $request->name; 
            $topics->alias = self::stripUnicode($request->name); 
            $topics->is_hot = $request->is_hot; 
            $topics->created_at = new DateTime();
            $topics->updated_at = new DateTime();
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
        else {
            return $validator->messages();
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

    public function update(TopicRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'is_hot' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $topic_id = $request->topic_id;
            $topic = $this->topic->find($topic_id);
            $topic->name = $request->input('name');
            $topic->is_hot = $request->input('is_hot');
            $topic->updated_at = new DateTime();

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
        else{
            return $validator->messages();    
        }   
    }

    public function getModalDelete(Request $request)
    {
        $model = 'topic';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.topic.topic.delete', ['topic_id' => $request->input('topic_id')]);
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
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

    public function getModalStatus(Request $request)
    {
        $model = 'topic';
        $type = 'status';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.topic.topic.status', ['topic_id' => $request->input('topic_id')]);
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function status(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $topic = $this->topic->find($topic_id);

        if (null != $topic) {
            if($topic->status == 0){
                $topic->status = 1;    
            }
            else{
                $topic->status = 0;
            }
            if($topic->save()){

            activity('topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Change status topic - topic_id: :properties.topic_id, name: ' . $topic->name);
            return redirect()->route('dhcd.topic.topic.manage')->with('success', trans('dhcd-topic::language.messages.success.status'));
        } else {
        }
            return redirect()->route('dhcd.topic.topic.manage')->with('error', trans('dhcd-topic::language.messages.error.status'));
        }
    }

    public function getModalAddAllMember(Request $request)
    {
        $model = 'topic';
        $type = 'add_all_member';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.topic.topic.add_all_member', ['topic_id' => $request->input('topic_id')]);
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function addAllMember(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $topic = $this->topic->find($topic_id);

        if (null != $topic) {
            $members = Member::where('visible',1)->select('member_id')->get();
            $data_insert = array();
            if(!empty($members)){
                foreach ($members as $key => $member) {
                    if (!TopicHasMember::where([
                        'topic_id' => $topic_id,
                        'member_id' => $member->member_id,
                    ])->exists()
                    )
                    {
                        $data_insert[] = [
                            'topic_id' => $topic_id,
                            'member_id' => $member->member_id
                        ];
                    }
                }
            }
            if(!empty($data_insert)){
                DB::table('dhcd_topic_has_member')->insert($data_insert);
            }
            activity('topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add all member topic - topic_id: :properties.topic_id, name: ' . $topic->name);
            return redirect()->route('dhcd.topic.topic.manage')->with('success', trans('dhcd-topic::language.messages.success.status'));
        }
        else{
            return redirect()->route('dhcd.topic.topic.manage')->with('error', trans('dhcd-topic::language.messages.error.status'));
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
                return view('DHCD-TOPIC::modules.topic.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-TOPIC::modules.topic.modal.modal_table', compact('error', 'model', 'confirm_route'));
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
                if ($this->user->canAccess('dhcd.topic.topic.log')) {
                    $actions = '<a href=' . route('dhcd.topic.topic.log', ['type' => 'topic', 'id' => $topics->topic_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log topic"></i></a>';
                }
                if ($this->user->canAccess('dhcd.topic.topic.show')) {
                    $actions .= '<a href=' . route('dhcd.topic.topic.show', ['topic_id' => $topics->topic_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update topic"></i></a>';
                }
                if ($this->user->canAccess('dhcd.topic.topic.confirm-delete')) {
                    $actions .= '<a href=' . route('dhcd.topic.topic.confirm-delete', ['topic_id' => $topics->topic_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete topic"></i></a>';
                } 
                if ($this->user->canAccess('dhcd.topic.topic.create.member')) {
                    $actions .= '<a href=' . route('dhcd.topic.topic.create.member', ['topic_id' => $topics->topic_id]) . '><i class="livicon" data-name="plus-alt" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="add member topic"></i></a>';
                }  
                return $actions;
            })
            ->addColumn('status', function ($topics) {
                if( $topics->status==0 ){
                    if ( $this->user->canAccess('dhcd.topic.topic.confirm-status') ) {
                        $status = '<a href=' . route('dhcd.topic.topic.confirm-status', ['topic_id' => $topics->topic_id]) . ' data-toggle="modal" data-target="#status_confirm"><span class="label label-sm label-danger">Disable</span></a> ';
                    }
                }
                else{
                    if ( $this->user->canAccess('dhcd.topic.topic.confirm-status') ) {
                        $status = '<a href=' . route('dhcd.topic.topic.confirm-status', ['topic_id' => $topics->topic_id]) . ' data-toggle="modal" data-target="#status_confirm"><span class="label label-sm label-success">Enable</span></a> ';
                    }  
                    if ( $this->user->canAccess('dhcd.topic.topic.confirm_add_all_member') ) {
                        $status .= ' <a href=' . route('dhcd.topic.topic.confirm_add_all_member', ['topic_id' => $topics->topic_id]) . ' data-toggle="modal" data-target="#add_all_member_confirm"><span class="label label-sm label-danger">Add All</span></a>';
                    } 
                }

                return $status;   
            })
            ->rawColumns(['actions','status'])
            ->make();
    }

    // add xoa tung member 
    public function createMember(Request $request){
        $topic_id = $request->topic_id;
        return view('DHCD-TOPIC::modules.topic.topic.addMember',compact('topic_id')); 
    }

    public function addMember(Request $request){
        $topic_id = $request->input('topic_id');
        $members = $request->list_members;
        $topic = $this->topic->find($topic_id);
        if (null != $topic && !empty($members)) {
            $data_insert = array();
            if(!empty($members)){
                foreach ($members as $key => $member) {
                    if (!TopicHasMember::where([
                        'topic_id' => $topic_id,
                        'member_id' => $member,
                    ])->exists()
                    )
                    {
                        $data_insert[] = [
                            'topic_id' => $topic_id,
                            'member_id' => $member
                        ];
                    }
                }
            }
            if(!empty($data_insert)){
                DB::table('dhcd_topic_has_member')->insert($data_insert);
            }
            activity('topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add single member topic - topic_id: :properties.topic_id, name: ' . $topic->name);
            return redirect()->route('dhcd.topic.topic.manage')->with('success', trans('dhcd-topic::language.messages.success.status'));
        }
        else{
            return redirect()->route('dhcd.topic.topic.manage')->with('error', trans('dhcd-topic::language.messages.error.status'));
        }
    }

    public function getModalDeleteMember(Request $request)
    {
        $model = 'topic';
        $type = 'delete_member';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required|numeric',
            'member' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.topic.topic.delete.member', ['topic_id' => $request->input('topic_id'),'member' => $request->input('member')]);
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-TOPIC::modules.topic.modal.modal_confirmation', compact('error', 'type' , 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function deleteMember(Request $request)
    {
        $topic_id = $request->input('topic_id');
        $topic = $this->topic->find($topic_id);
        $members = explode(",",$request->input('member'));
        if (!empty($members)) {
            foreach ($members as $key => $member) {
                DB::table('dhcd_topic_has_member')->where(['topic_id' => $topic_id,'member_id' => $member])->delete();
            }
            activity('topic')
                ->performedOn($topic)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete member topic - topic_id: :properties.topic_id, name: ' . $topic->name);

            return redirect()->route('dhcd.topic.topic.create.member',['topic_id' => $topic_id])->with('success', trans('dhcd-topic::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.topic.topic.create.member',['topic_id' => $topic_id])->with('error', trans('dhcd-topic::language.messages.error.delete'));
        }
    }

    public function dataMember(Request $request)
    {
        $topic_id = $request->topic_id;
        $topic = Topic::where('topic_id', $topic_id)->with('getMember')->first();
        $members = $topic->getMember;
        return Datatables::of($members)
            ->addColumn('actions', function ($members) use ($topic_id) {
                $actions = '<input id="'.$members->member_id.'" type="checkbox" value="" class="select-member">';
                return $actions;
            })
            ->addColumn('DT_RowId', function ($members) {
                return $members->member_id;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    public function searchMember(Request $request) {
        $data = [];
        if ($request->ajax()) {
            $keyword = $request->keyword;
            $topic_id = $request->topic_id;
            if(!empty($keyword)){
                $list_member_old = TopicHasMember::where('topic_id',$topic_id)->select('member_id')->get();
                $list_members = Member::where('name', 'like', '%' . $keyword . '%')->whereNotIn('member_id', $list_member_old)->get();
                if(!empty($list_members)){
                    foreach($list_members as $member){
                        $data[] = [
                            'name' => $member->name,
                            'member_id' => $member->member_id
                        ];
                    }
                }
            }
        }
        echo json_encode($data);
    }
    // add xoa tung member 
}
