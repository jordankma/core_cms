<?php

namespace Dhcd\Events\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Events\App\Repositories\EventsRepository;
use Dhcd\Events\App\Models\Events;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;


class EventsController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(EventsRepository $eventsRepository)
    {
        parent::__construct();
        $this->events = $eventsRepository;
    }

    public function manage()
    {
        return view('DHCD-EVENTS::modules.events.events.manage');
    }

    public function add(Request $request)
    {   
        // validate field name and content
        $validate = Validator::make(
        $request->all(),
            [
            'name' => 'required|min:5|max:255',
            'content' => 'required|min:5'
            ],
            [
            'required' => 'Vui lòng nhập thông tin',
            'min' => 'Giá trị không được nhỏ hơn :5',
            'max' => 'Không được lớn hơn :255'
            ]
       );
        if ($validate->fails()) {
           return redirect()->route('dhcd.events.events.create')->withErrors($validate);
        }
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        $event_content =$request->event_content;
        if($start_time == '' or $start_time == null) {
           return redirect()->route('dhcd.events.events.create')->with('error', trans('dhcd-events::language.messages.error.start_time'));
        } else {
            $result = [];
            for ($i = 0; $i < sizeof($start_time); $i++){
                if($start_time[$i]==null || $start_time[$i] =='' || empty($start_time[$i]))
                {
                     return redirect()->route('dhcd.events.events.create')->with('error', trans('dhcd-events::language.messages.error.create'));
                }
                if($end_time[$i]==null || $end_time[$i] =='' || empty($end_time[$i]))
                {
                     return redirect()->route('dhcd.events.events.create')->with('error', trans('dhcd-events::language.messages.error.create'));
                }
                if($event_content[$i]==null || $event_content[$i] =='' || empty($event_content[$i]))
                {
                     return redirect()->route('dhcd.events.events.create')->with('error', trans('dhcd-events::language.messages.error.create'));
                }
                $result[$i] = [
                    "start_time" => $start_time[$i],
                    "end_time" => $end_time[$i],
                    "content" => $event_content[$i]
                ];
            }
            $event_detail=json_encode($result,JSON_UNESCAPED_UNICODE);
        }

        if(!$request->status)$request->status=1;
        $events = new Events();
        $events->name=$request->name;
        $events->date=date("Y-m-d", strtotime($request->date));
        $events->content=$request->content;
        $events->status=$request->status;
        $events->event_detail= $event_detail;
        $events->save();
        if ($events->event_id) {
            activity('events')
                ->performedOn($events)
                ->withProperties($request->all())
                ->log('User: :causer.email - Add Event - name: :properties.name, event_id: ' . $events->event_id);
            return redirect()->route('dhcd.events.events.manage')->with('success', trans('dhcd-events::language.messages.success.create'));
        } else {
            return redirect()->route('dhcd.events.events.manage')->with('error', trans('dhcd-events::language.messages.error.create'));
        }
    }

    public function create()
    {  
        return view('DHCD-EVENTS::modules.events.events.create');
    }

    public function delete(Request $request)
    {
        $event_id = $request->input('id');
        $events = Events::find($event_id);
        if (null != $events) {
            $events->delete($event_id);
            activity('events')
                ->performedOn($events)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete events - id: :properties.id, name: ' . $events->name);
            return redirect()->route('dhcd.events.events.manage')->with('success', trans('dhcd-events::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.events.events.manage')->with('error', trans('dhcd-events::language.messages.error.delete'));
        }
    }

    public function show(Request $request)
    {
         $validate = Validator::make(
                $request->all(),
                    [
                    'event_id'=>'required|numeric'
                    ],
                    [
                    'required' => 'Vui lòng nhập thông tin'
                    ]
               );
        if ($validate->fails()) {
            if ($request->has('event_id')) {
                $event_id = $request->input('event_id');
                return redirect()->route('dhcd.events.events.show', ['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.name_event_null'));
            } else {
                return redirect()->route('dhcd.events.events.manage')->with('error', trans('dhcd-events::language.messages.error.name_event_null'));
            }
        }
        $event_id = $request->input('event_id');
        $event = Events::find($event_id);
        $event_detail  = json_decode($event->event_detail);
        $event_date = date("d/m/Y", strtotime($event->date));
        $data = [
            'event' => $event,
            'event_detail' => $event_detail,
            'event_date' => $event_date
        ];
        return view('DHCD-EVENTS::modules.events.events.edit', $data, $event_detail, $event_date);
    }

    public function update(Request $request)
    {
       
        $validate = Validator::make(
                $request->all(),
                    [
                    'event_id'=>'required|numeric',
                    'name' => 'required|min:5|max:255',
                    'content' => 'required|min:5|max:255'
                    ],
                    [
                    'required' => 'Vui lòng nhập thông tin',
                    'min' => 'Giá trị không được nhỏ hơn :5',
                    'max' => 'Không được lớn hơn :255'
                    ]
               );
        if ($validate->fails()) {
            if ($request->has('event_id')) {
                $event_id = $request->input('event_id');
                return redirect()->route('dhcd.events.events.show', ['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.name_event_null'));
            } else {
                return redirect()->route('dhcd.events.events.manage')->with('error', trans('dhcd-events::language.messages.error.name_event_null'));
            }
          
        }
        $event_id = $request->input('event_id');
        $start_time=$request->start_time;
        $end_time=$request->end_time;
        $event_content =$request->event_content;
                if($start_time == '' || $start_time == null || empty($start_time)){
                    return redirect()->route('dhcd.events.events.show',['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.update'));
                }
                else{
                    $result = [];
                        for ($i = 0; $i < sizeof($start_time); $i++){
                            if($start_time[$i]==null || $start_time[$i] =='' || empty($start_time[$i]))
                            {
                                 return redirect()->route('dhcd.events.events.show',['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.update'));
                            }
                            if($end_time[$i]==null || $end_time[$i] =='' || empty($end_time[$i]))
                            {
                                 return redirect()->route('dhcd.events.events.show',['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.update'));
                            }
                            if($event_content[$i]==null || $event_content[$i] =='' || empty($event_content[$i]))
                            {
                                 return redirect()->route('dhcd.events.events.show',['event_id' => $event_id])->with('error', trans('dhcd-events::language.messages.error.update'));
                            }
                            $result["$i"] = [
                            "start_time" => $start_time[$i],
                            "end_time" => $end_time[$i],
                            "content" => $event_content[$i]
                        ];
                    }
                    $event_detail=json_encode($result,JSON_UNESCAPED_UNICODE);
                }
                


        if(!$request->status)$request->status=0;
        $event = Events::find($event_id);
        $event->name=$request->name;
        $event->date=date("Y-m-d", strtotime($request->date));
        $event->content=$request->content;
        $event->status=$request->status;
        $event->event_detail= $event_detail;
        $event->save();
        if ($event->save()) {
            activity('events')
                ->performedOn($event)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update events - event_id: :properties.event_id, name: :properties.name');
            return redirect()->route('dhcd.events.events.manage')->with('success', trans('dhcd-events::language.messages.success.update'));
        } else {
            return redirect()->route('dhcd.events.events.show', ['event_id' => $request->input('event_id')])->with('error', trans('dhcd-events::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'events';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.events.events.delete', ['id' => $request->input('event_id')]);
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_confirmation', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->events->findAll())
        ->editColumn('date',function($events){
            $date = $events->date;
           return date("d-m-Y", strtotime($date));
        })
        ->editColumn('event_detail',function($events){
            $event_detail='<a href=' . route('dhcd.events.events.detail', ['type' => 'event_id', 'event_id' => $events->event_id]) . ' data-toggle="modal" data-target="#event_detail"><center><button class="btn btn-primary">Chi Tiết
            </button></center></a>';
            return $event_detail;
        })
        ->editColumn('status', function ($events) { 
            if($events->status===1){
                return '<lable>Đã Công Khai</label>';
            } else
            {
                return '<lable>Chưa Công Khai</label>';
            }             
            })
            ->addColumn('actions', function ($events) {
                $actions = '';
                if($this->user->canAccess('dhcd.events.events.log')){
                    $actions .='<a href=' . route('dhcd.events.events.log', ['type' => 'event_id', 'event_id' => $events->event_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log events"></i></a>';
                }
                if($this->user->canAccess('dhcd.events.events.show')){
                    $actions .='<a href=' . route('dhcd.events.events.show', ['event_id' => $events->event_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update events"></i></a>';
                }      
                if($this->user->canAccess('dhcd.events.events.confirm-delete')){
                    $actions .='<a href=' . route('dhcd.events.events.confirm-delete', ['event_id' => $events->event_id]). ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete events"></i></a>';
                }       
                return $actions;               
            })
            ->rawColumns(['status','actions','date','event_detail','current_time'])
            ->make();
    }

     public function log(Request $request)
    {
        $model = 'events';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'type' => 'required',
            'event_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $logs = Activity::where([
                    ['log_name', $model],
                    ['subject_id', $request->input('event_id')]
                ])->get();
                return view('includes.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('includes.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function detail(Request $request)
    { 
        $event_id = $request->input('event_id');
        $events=Events::find($event_id);
        $event_detail  = json_decode($events->event_detail);
        return view('DHCD-EVENTS::modules.events.events.modal_event', compact('event_detail'));
    }
  
}


