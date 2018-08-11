<?php

namespace Dhcd\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\Controller as Controller;
use Dhcd\Member\App\Repositories\MemberRepository;
use Dhcd\Member\App\Models\Member;
use Dhcd\Member\App\Http\Requests\MemberRequest;

use Dhcd\Member\App\Models\Position;

use Spatie\Activitylog\Models\Activity;
use Yajra\Datatables\Datatables;
use Validator,Auth,DateTime,DB;
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
        $list_position = Position::all();
        $list_trinh_do_ly_luan = Member::select('trinh_do_ly_luan')->groupBy('trinh_do_ly_luan')->get();
        $list_trinh_do_chuyen_mon = Member::select('trinh_do_chuyen_mon')->groupBy('trinh_do_chuyen_mon')->get();
        return view('DHCD-MEMBER::modules.member.member.create',compact('list_position','list_trinh_do_ly_luan','list_trinh_do_chuyen_mon'));
    }

    public function add(MemberRequest $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50'
        ], $this->messages);
        if (!$validator->fails()) {
            $members = new Member();
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $position_id = $request->input('position_id');
            $position_current = $request->input('position_current');
            $trinh_do_ly_luan = $request->input('trinh_do_ly_luan');
            $trinh_do_chuyen_mon = $request->input('trinh_do_chuyen_mon');
            $address = $request->input('address'); 
            $don_vi = $request->input('don_vi'); 
            $gender = $request->input('gender'); 
            $dan_toc = $request->input('dan_toc'); 
            $ton_giao = $request->input('ton_giao'); 
            $token = $request->input('_token');
            $birthday = $request->input('birthday'); 
            $ngay_vao_dang = $request->input('ngay_vao_dang'); 
            $ngay_vao_doan = $request->input('ngay_vao_doan'); 
            $avatar = !empty($request->input('avatar')) ? $request->input('avatar') :'';

            $members->name = $name;
            $members->email = $email;
            $members->phone = $phone;
            $members->position_id = $position_id;
            $members->position_current = $position_current;
            $members->trinh_do_ly_luan = $trinh_do_ly_luan;
            $members->trinh_do_chuyen_mon = $trinh_do_chuyen_mon;
            $members->address = $address;
            $members->don_vi = $don_vi;
            $members->gender = $gender;
            $members->dan_toc = $dan_toc;
            $members->ton_giao = $ton_giao;
            $members->token = $token;   
            $members->birthday = $birthday;
            $members->ngay_vao_dang = $ngay_vao_dang;
            $members->ngay_vao_doan = $ngay_vao_doan;
            $members->avatar = $avatar;
            $members->reg_ip = '8.8.8.8';
            $members->last_ip = '8.8.8.8';
            $members->last_login = new DateTime();
            $members->created_at = new DateTime();
            $members->updated_at = new DateTime();
            if ($members->save()) {
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
        $list_position = Position::all();
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
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
        ], $this->messages);
        if (!$validator->fails()) { 
            $member_id = $request->input('member_id');
            $member = $this->member->find($member_id);
            $name = $request->input('name');
            $email = $request->input('email');
            $phone = $request->input('phone');
            $position_id = $request->input('position_id');
            $position_current = $request->input('position_current');
            $trinh_do_ly_luan = $request->input('trinh_do_ly_luan');
            $trinh_do_chuyen_mon = $request->input('trinh_do_chuyen_mon');
            $address = $request->input('address'); 
            $don_vi = $request->input('don_vi'); 
            $gender = $request->input('gender'); 
            $dan_toc = $request->input('dan_toc'); 
            $ton_giao = $request->input('ton_giao'); 
            $token = $request->input('_token');
            $birthday = $request->input('birthday'); 
            $ngay_vao_dang = $request->input('ngay_vao_dang'); 
            $ngay_vao_doan = $request->input('ngay_vao_doan'); 
            $avatar = !empty($request->input('avatar')) ? $request->input('avatar') :'';

            $member->name = $name;
            $member->email = $email;
            $member->phone = $phone;
            $member->position_id = $position_id;
            $member->position_current = $position_current;
            $member->trinh_do_ly_luan = $trinh_do_ly_luan;
            $member->trinh_do_chuyen_mon = $trinh_do_chuyen_mon;
            $member->address = $address;
            $member->don_vi = $don_vi;
            $member->gender = $gender;
            $member->dan_toc = $dan_toc;
            $member->ton_giao = $ton_giao;
            $member->token = $token;
            $member->birthday = $birthday;
            $member->ngay_vao_dang = $ngay_vao_dang;
            $member->ngay_vao_doan = $ngay_vao_doan;
            $member->avatar = $avatar;
            $member->updated_at = new DateTime();
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
        $members = $this->member->all();
        return Datatables::of($members)
            ->addIndexColumn()
            ->addColumn('actions', function ($members) {
                $actions = '';
                if ($this->user->canAccess('dhcd.member.member.log')) {
                    $actions .= '<a href=' . route('dhcd.member.member.log', ['type' => 'member', 'id' => $members->member_id]) . ' data-toggle="modal" data-target="#log"><i class="livicon" data-name="info" data-size="18" data-loop="true" data-c="#F99928" data-hc="#F99928" title="log member"></i></a>';
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
            ->addColumn('position', function ($members) {
                $position = $members->position_current;
                return $position;
            })
            ->rawColumns(['actions','status'])
            ->make();
    }

    public function checkEmailExist(Request $request){
        $data['valid'] = true;
        if ($request->ajax()) {
            $member =  Member::where(['email' => $request->email])->first();
            if ($member) {
                $data['valid'] = false; // true là có user
            }
        }
        echo json_encode($data);
    }

    public function checkPhoneExist(Request $request){
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
        // $group_name = config('site.group_name');
        // $skin = config('site.desktop.skin');
        // $url = public_path('/vendor/' . $group_name . '/' . $skin .'/dhcd/news/uploads/tnxh.xlsx');
        // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($url);
        // $worksheet = $spreadsheet->getActiveSheet();
        // $rows = [];
        // foreach ($worksheet->getRowIterator() AS $row) {
        //     $cellIterator = $row->getCellIterator();
        //     $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        //     $cells = [];
        //     foreach ($cellIterator as $cell) {
        //         $cells[] = $cell->getValue();
        //     }
        //     $rows[] = $cells;
        // }
        // echo '<pre>';
        // print_r($rows);
        // echo '</pre>'; die;
        return view('DHCD-MEMBER::modules.member.member.import');    
    }

    public function postImport(Request $request){   
        $validator = Validator::make($request->all(), [
            'path' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $term = $request->input('path');
            $url = substr($term, 1, strlen($term));
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($url);
            $worksheet = $spreadsheet->getActiveSheet();
            $rows = [];
            foreach ($worksheet->getRowIterator() AS $row) {
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
                $cells = [];
                foreach ($cellIterator as $cell) {
                    $cells[] = $cell->getValue();
                }
                $rows[] = $cells;
            }
            if(!empty($rows)){
                foreach ($rows as $key => $value) {
                    $data_insert[] = [
                        'name' => $value[0],
                        'position_current' => $value[1]
                    ];
                }
            } else {
                return redirect()->route('dhcd.member.member.manage')->with('error', trans('dhcd-member::language.messages.error.import'));    
            }
            if(!empty($data_insert)){
                if(DB::table('dhcd_member')->insert($data_insert)){
                    return redirect()->route('dhcd.member.member.manage')->with('success', trans('dhcd-member::language.messages.success.import'));
                }
            } 
            else {
                return redirect()->route('dhcd.member.member.manage')->with('error', trans('dhcd-member::language.messages.error.import'));
            }
        } else {
            return $validator->messages(); 
        }
    }
}
