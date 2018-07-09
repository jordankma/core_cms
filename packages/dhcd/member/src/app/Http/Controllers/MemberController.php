<?php

namespace Dhcd\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Member\App\Repositories\MemberRepository;
use Dhcd\Member\App\Models\Member;
use Dhcd\Member\App\http\Requests\MemberRequest;
use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator;
use Auth;
use DateTime;
use Dhcd\Administration\App\Models\ProvineCity;
use Dhcd\Administration\App\Models\CountryDistrict;
class MemberController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số",
        'phone.regex' =>'Sai định dạng'
    );

    public function __construct(MemberRepository $memberRepository)
    {
        parent::__construct();
        $this->member = $memberRepository;
    }

    public function manage()
    {
        return view('DHCD-MEMBER::modules.member.member.manage');
    }

    public function create()
    {
        $list_position = Member::select('position')->groupBy('position')->get();
        $list_trinh_do_ly_luan = Member::select('trinh_do_ly_luan')->groupBy('trinh_do_ly_luan')->get();
        $list_trinh_do_chuyen_mon = Member::select('trinh_do_chuyen_mon')->groupBy('trinh_do_chuyen_mon')->get();
        return view('DHCD-MEMBER::modules.member.member.create',compact('list_position','list_trinh_do_ly_luan','list_trinh_do_chuyen_mon'));
    }

    public function add(MemberRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
            'u_name' => 'required|unique:dhcd_member,u_name|min:3|max:50',
            'password' => 'required|min:8|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$"',
            'conf_password' => 'required|min:8|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$"',
            'email' => 'required|unique:dhcd_member,email',
        ], $this->messages);
        if (!$validator->fails()) {
            $members = new Member();
            $name = $request->name; 
            $u_name = $request->u_name; 
            $email = $request->email; 
            $phone = $request->phone;
            $position = $request->position;
            $trinh_do_ly_luan = $request->trinh_do_ly_luan;
            $trinh_do_chuyen_mon = $request->trinh_do_chuyen_mon;
            $password = bcrypt($request->password);
            $address = $request->address; 
            $don_vi = $request->don_vi; 
            $gender = $request->gender; 
            $dan_toc = $request->dan_toc; 
            $ton_giao = $request->ton_giao; 
            $token = $request->_token;
            $birthday = $request->birthday; 
            $ngay_vao_dang = $request->ngay_vao_dang; 
            $avatar = !empty($request->avatar) ? $request->avatar :'';

            $members->name = $name;
            $members->u_name = $u_name;
            $members->email = $email;
            $members->phone = $phone;
            $members->position = $position;
            $members->trinh_do_ly_luan = $trinh_do_ly_luan;
            $members->trinh_do_chuyen_mon = $trinh_do_chuyen_mon;
            $members->password = $password;
            $members->address = $address;
            $members->don_vi = $don_vi;
            $members->gender = $gender;
            $members->dan_toc = $dan_toc;
            $members->ton_giao = $ton_giao;
            $members->token = $token;
            $members->birthday = $birthday;
            $members->ngay_vao_dang = $ngay_vao_dang;
            $members->avatar = $avatar;
            $members->reg_ip = '8.8.8.8';
            $members->last_ip = '8.8.8.8';
            $members->last_login = new DateTime();
            $members->created_at = new DateTime();
            $members->updated_at = new DateTime();
            $members->save();
            if ($members->member_id) {
                activity('member')
                    ->performedOn($members)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Add member - name: :properties.name, member_id: ' . $members->member_id);

                return redirect()->route('dhcd.member.member.manage')->with('success', trans('dhcd-member::language.messages.success.create'));
            } else {
                return redirect()->route('dhcd.member.member.manage')->with('error', trans('dhcd-member::language.messages.error.create'));
            }
        }
        else{
            return $validator->messages();    
        }
    } 

    public function show(MemberRequest $request)
    {
        $list_position = Member::select('position')->groupBy('position')->get();
        $list_trinh_do_ly_luan = Member::select('trinh_do_ly_luan')->groupBy('trinh_do_ly_luan')->get();
        $list_trinh_do_chuyen_mon = Member::select('trinh_do_chuyen_mon')->groupBy('trinh_do_chuyen_mon')->get();
        $member_id = $request->input('member_id');
        $member = $this->member->find($member_id);
        $data = [
            'member' => $member,
            'list_position' => $list_position,
            'list_trinh_do_ly_luan' => $list_trinh_do_ly_luan,
            'list_trinh_do_chuyen_mon' => $list_trinh_do_chuyen_mon,
        ];

        return view('DHCD-MEMBER::modules.member.member.edit', $data);
    }

    public function update(MemberRequest $request)
    {
        $member_id = $request->member_id;
        $member = $this->member->find($member_id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
        ], $this->messages);
        if (!$validator->fails()) { 
            $name = $request->name;
            $position = $request->position;
            $trinh_do_ly_luan = $request->trinh_do_ly_luan;
            $trinh_do_chuyen_mon = $request->trinh_do_chuyen_mon;
            $address = $request->address; 
            $don_vi = $request->don_vi; 
            $gender = $request->gender; 
            $dan_toc = $request->dan_toc; 
            $ton_giao = $request->ton_giao;
            $birthday = $request->birthday; 
            $ngay_vao_dang = $request->ngay_vao_dang; 
            $avatar = !empty($request->avatar) ? $request->avatar :'';

            $member->name = $name;
            $member->position = $position;
            $member->trinh_do_ly_luan = $trinh_do_ly_luan;
            $member->trinh_do_chuyen_mon = $trinh_do_chuyen_mon;
            $member->address = $address;
            $member->don_vi = $don_vi;
            $member->gender = $gender;
            $member->dan_toc = $dan_toc;
            $member->ton_giao = $ton_giao;
            $member->birthday = $birthday;
            $member->ngay_vao_dang = $ngay_vao_dang;
            $member->avatar = $avatar;
            $member->updated_at = new DateTime();
            $member->save();
            if ($member->save()) {
                activity('member')
                    ->performedOn($member)
                    ->withProperties($request->all())
                    ->log('User: :causer.email - Update member - member_id: :properties.member_id, name: :properties.name');
                return redirect()->route('dhcd.member.member.manage')->with('success', trans('dhcd-member::language.messages.success.update'));
            } else {
                return redirect()->route('dhcd.member.member.show', ['member_id' => $request->input('member_id')])->with('error', trans('dhcd-member::language.messages.error.update'));
            }
        }
        else{
            return $validator->messages();    
        }
    }

    public function delete(Request $request)
    {
        $member_id = $request->input('member_id');
        $member = $this->member->find($member_id);
        if (null != $member) {
            $this->member->delete($member_id);
            activity('member')
                ->performedOn($member)
                ->withProperties($request->all())
                ->log('User: :causer.email - Delete member - member_id: :properties.member_id, name: ' . $member->name);

            return redirect()->route('dhcd.member.member.manage')->with('success', trans('dhcd-member::language.messages.success.delete'));
        } else {
            return redirect()->route('dhcd.member.member.manage')->with('error', trans('dhcd-member::language.messages.error.delete'));
        }
    }

    public function getModalDelete(Request $request)
    {
        $model = 'member';
        $type = 'delete';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.member.member.delete', ['member_id' => $request->input('member_id')]);
                return view('DHCD-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function block(Request $request)
    {
        $member_id = $request->input('member_id');
        $member = $this->member->find($member_id);
        if (null != $member) {
            $member->status = 2;
            $member->save();
            activity('member')
                ->performedOn($member)
                ->withProperties($request->all())
                ->log('User: :causer.email - Block member - member_id: :properties.member_id, name: ' . $member->name);

            return redirect()->route('dhcd.member.member.manage')->with('success', trans('dhcd-member::language.messages.success.block'));
        } else {
            return redirect()->route('dhcd.member.member.manage')->with('error', trans('dhcd-member::language.messages.error.block'));
        }
    }

    public function getModalBlock(Request $request)
    {
        $model = 'member';
        $type = 'block';
        $confirm_route = $error = null;
        $validator = Validator::make($request->all(), [
            'member_id' => 'required|numeric',
        ], $this->messages);
        if (!$validator->fails()) {
            try {
                $confirm_route = route('dhcd.member.member.block', ['member_id' => $request->input('member_id')]);
                return view('DHCD-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-MEMBER::modules.member.modal.modal_confirmation', compact('error','type', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    public function log(Request $request)
    {
        $model = 'member';
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
                return view('DHCD-MEMBER::modules.member.modal.modal_table', compact('error', 'model', 'confirm_route', 'logs'));
            } catch (GroupNotFoundException $e) {
                return view('DHCD-MEMBER::modules.member.modal.modal_table', compact('error', 'model', 'confirm_route'));
            }
        } else {
            return $validator->messages();
        }
    }

    //Table Data to index page
    public function data()
    {
        $members = $this->member->findAll();
        return Datatables::of($members)
            ->addIndexColumn()
            ->addColumn('actions', function ($members) {
                if ($this->user->canAccess('dhcd.member.member.log')) {
                    $actions = '<a href=' . route('dhcd.member.member.log', ['type' => 'member', 'id' => $members->member_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log member"></i></a>';
                }
                if ($this->user->canAccess('dhcd.member.member.show')) {
                    $actions .='<a href=' . route('dhcd.member.member.show', ['member_id' => $members->member_id]) . '><i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="update member"></i></a>';
                }
                if ($this->user->canAccess('dhcd.member.member.confirm-delete')) {
                    $actions .= '<a href=' . route('dhcd.member.member.confirm-delete', ['member_id' => $members->member_id]) . ' data-toggle="modal" data-target="#delete_confirm"><i class="livicon" data-name="trash" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete member"></i></a>
                        ';
                }
                return $actions;
            })
            ->addColumn('status', function ($members) {
                if ($members->status == 1) {
                    $status = '<span class="label label-sm label-success">Enable</span>';
                } else {
                    $status = '<span class="label label-sm label-danger">Disable</span>';
                }
                return $status;
            })
            ->rawColumns(['actions','status'])
            ->make();
    }
    public function checkUserNameExist(MemberRequest $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $member =  Member::where(['u_name' => $request->u_name])->first();
            if ($member) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function checkEmailExist(MemberRequest $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $member =  Member::where(['email' => $request->email])->first();
            if ($member) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function checkPhoneExist(MemberRequest $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $member =  Member::where(['phone' => $request->phone])->first();
            if ($member) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function getImport(){
        return view('DHCD-MEMBER::modules.member.member.import');    
    }

    public function postImport(Request $request){
        dd($request->all());   
    }
}
