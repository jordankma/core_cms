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
        $member = Member::find($member_id);
        if(empty($member)){
            return false;
        }
        $data = [
            'member' => $member    
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
}
