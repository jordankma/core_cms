<?php

namespace Dhcd\Notification\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Notification\App\Repositories\NotificationRepository;
use Dhcd\Notification\App\Models\Notification;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,DateTime;
use Dhcd\Member\App\Models\Member;
class NotificationController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(NotificationRepository $notificationRepository)
    {
        parent::__construct();
        $this->notification = $notificationRepository;
    }

    public function manage()
    {
        return view('DHCD-NOTIFICATION::modules.notification.notification.manage');
    }

    public function create()
    {
        return view('DHCD-NOTIFICATION::modules.notification.notification.create');
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], $this->messages);
        if (!$validator->fails()) {
            // dd(gettype($request->type_sent));
            $time_sent = '';
            if(isset($request->time_sent) && $request->input('time_sent') != ''){
                $date = new DateTime($request->input('time_sent'));
                $time_sent = $date->format('Y-m-d H:i:s');
            }

            $type_sent = $request->input('type_sent');
            $member_sent = array();
            if($type_sent == 2){
                $member_sent = $request->input('list_member_sent');
            }
            // if($time_sent !=''){

            // }
            // else{
            //     if($type_sent==1){
            //         $this->sentNotification();
                    
            //     }
            // }
            $notifications = new Notification();
            $notifications->name = $request->input('name');
            $notifications->name = self::stripUnicode($request->input('name'));
            $notifications->content = $request->input('content');
            $notifications->type_sent = $type_sent;
            $notifications->time_sent = $time_sent;
            $notifications->member_sent = json_encode($member_sent);
            $notifications->created_at = new DateTime();
            $notifications->updated_at = new DateTime();
            if ($notifications->save()) {

                activity('notification')
                    ->performedOn($notifications)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add notification - name: :properties.name, notification_id: ' . $notifications->notification_id);

                return redirect()->route('dhcd.notification.notification.manage')->with('success', trans('dhcd-notification::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.notification.notification.manage')->with('error', trans('dhcd-notification::language.messages.error.create'));
            }
        }
        else {
            return $validator->messages();
        }
    }

    public function show(Request $request)
    {
        $demo_id = $request->input('demo_id');
        $demo = $this->demo->find($demo_id);
        $data = [
            'demo' => $demo
        ];

        return view('DHCD-NOTIFICATION::modules.notification.demo.edit', $data);
    }

    public function update(Request $request)
    {
        $demo_id = $request->input('demo_id');

        $demo = $this->demo->find($demo_id);
        $demo->name = $request->input('name');

        if ($demo->save()) {

            activity('demo')
                ->performedOn($demo)
                ->withProperties($request->all())
                ->log('User: :causer.email - Update Demo - demo_id: :properties.demo_id, name: :properties.name');

            return redirect()->route('dhcd.notification.demo.manage')->with('success', trans('dhcd-notification::language.messages.success.update'));
        } else {
            return redirect()->route('dhcd.notification.demo.show', ['demo_id' => $request->input('demo_id')])->with('error', trans('dhcd-notification::language.messages.error.update'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'notification';
        $type = "delete";
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'notification_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.notification.notification.delete', ['notification_id' => $request->input('notification_id')]);
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_confirmation', compact('type','error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function delete(Request $request)
    {
        $notification_id = $request->input('notification_id');
        $notification = $this->notification->find($notification_id);

        if (null != $notification) {
            $this->notification->delete($notification_id);

            activity('notification')
                ->performedOn($notification)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete notification - notification_id: :properties.notification_id, name: ' . $notification->name);

            return redirect()->route('dhcd.notification.notification.manage')->with('success', trans('dhcd-notification::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.notification.notification.manage')->with('error', trans('dhcd-notification::language.messages.error.delete'));
        }
    }

    public function log(Request $request)
    {
        $model = 'notification';
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
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-NOTIFICATION::modules.notification.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        return Datatables::of($this->notification->findAll())
            ->addColumn('actions', function ($notifications) {
                $actions = '';
                if ($this->user->canAccess('dhcd.notification.notification.log')) {
                    $actions .= '<a href=' . route('dhcd.notification.notification.log', ['type' => 'notification', 'id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log notification"></i></a>';
                }
                // if ($this->user->canAccess('dhcd.notification.notification.show')) {
                //     $actions .= '<a href=' . route('dhcd.notification.notification.show', ['notification_id' => $notifications->notification_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update notification"></i></a>';
                // }
                if ($this->user->canAccess('dhcd.notification.notification.confirm-delete')) {        
                    $actions .= '<a href=' . route('dhcd.notification.notification.confirm-delete', ['notification_id' => $notifications->notification_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete notification"></i></a>';
                }
                return $actions;
            })
            ->addColumn('time_sent', function ($notifications) {
                $time_sent = $notifications->time_sent;
                if($time_sent == '' || $time_sent == null){
                    $time_sent = "Đã gửi";    
                }
                else{
                    $date = new DateTime();
                    $time_sent = date_format($date, 'h:i:s d-m-Y');
                }
                return $time_sent;   
            })
            ->addIndexColumn()
            ->rawColumns(['actions','time_sent'])
            ->make();
    }

    public function searchMember(Request $request) {
        $data = [];
        if ($request->ajax()) {
            $keyword = $request->input('keyword');
            if(!empty($keyword)){
                $list_members = Member::where('name', 'like', '%' . $keyword . '%')->get();
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

    public function sentNotification(){

    }
}
