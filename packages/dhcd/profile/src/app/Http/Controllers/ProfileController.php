<?php

namespace Dhcd\Profile\App\Http\Controllers;

use Illuminate\Http\Request;
use Adtech\Application\Cms\Controllers\MController as Controller;

use Dhcd\Member\App\Repositories\MemberRepository;

use Dhcd\Member\App\Models\Member;

use Validator,Auth,Hash;

class ProfileController extends Controller
{
    private $messages = array(
        'name.regex' => "Sai định dạng",
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

    public function __construct(MemberRepository $memberRepository)
    {
        parent::__construct();
        $this->member = $memberRepository;
        $this->_member = Auth::user();
    }
    public function profile(){
        $member_id = $this->user->member_id;
        $url_storage = config('site.url_storage');
        $member = Member::find($member_id);
        if(empty($member)){
            return false;
        }
        $data = [
            'member' => $member,
            'url_storage' => $url_storage   
        ]; 
        return view('DHCD-PROFILE::modules.profile.profile',$data);
    }

    public function changePass(Request $request){
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password' => 'required|min:8|regex:"^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$"'
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $this->user->member_id;
            $old_password = $request->old_password;
            $new_password = $request->password;
            $member = Member::find($member_id);
            if(!empty($member)){
                $password = $member->password;
                if (Hash::check($old_password , $password) && $old_password != $new_password){
                    Member::where('member_id',$member_id)->update(['password' => bcrypt($new_password)]);
                    return redirect()->route('profile.member')->with('success', trans('dhcd-profile::language.messages.success.change_pass'));
                }
            }
        }   
        return redirect()->route('profile.member')->with('error', trans('dhcd-profile::language.messages.error.change_pass'));
    }

    public function xedit(){
        return view('DHCD-PROFILE::modules.profile.xedit');
    }

    public function changeName(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1|max:50',
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $this->user->member_id;
            $member = Member::find($member_id);
            $name = $request->get('value');
            if($member != null){
                $member->name = $name;
                $member->save();   
            }
        } else {
            return $validator->messages();
        }
    }

    public function changeDanToc(Request $request){
        $member_id = $this->user->member_id;
        $member = Member::find($member_id);
        $dan_toc = $request->get('value');
        if($member != null){
            $member->dan_toc = $dan_toc;
            $member->save();   
        }
    }

    public function changeAddress(Request $request){
        $member_id = $this->user->member_id;
        $member = Member::find($member_id);
        $address = $request->get('value');
        if($member != null){
            $member->address = $address;
            $member->save();   
        }
    }

    public function changeTonGiao(Request $request){
        $member_id = $this->user->member_id;
        $member = Member::find($member_id);
        $ton_giao = $request->get('value');
        if($member != null){
            $member->ton_giao = $ton_giao;
            $member->save();   
        }
    }
}
