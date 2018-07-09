<?php

namespace Dhcd\Member\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

use Dhcd\Member\App\Http\Requests\ApiMemberRequest;

use Dhcd\Member\App\Models\Member;
use Dhcd\Member\App\Repositories\MemberRepository;
use Validator,Auth;


class ApiMemberController extends BaseController
{	
	private $messages = array(
        'required' => "Bắt buộc",
        'numeric'  => "Phải là số"
    );

	public function postLogin(ApiMemberRequest $request){
		$data = [
			"success" => false,
			"message" => "Login thất bại",	
		];
		$validator = Validator::make($request->all(), [
            'u_name' => 'required|min:1|max:200',
            'password' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
			$u_name = 'tuanlvd@gmail.com';
			$password = '123456';
			$data = [
				"user" => [
				 	"id"  => "aaaaa",
				 	"u_name" => "abc@gmail.com",
				 	"ten_hien_thi" => "aaaa",
				 	"token" => [
				 		"token" => "aaaaaaa"
				 	]
				]
			];
			return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}
		else{
			return response(json_encode($data))->setStatusCode(404)->header('Content-Type', 'application/json; charset=utf-8');
		}
	}

	public function getUserInfo(ApiMemberRequest $request){
		$data = [
			"success" => false,
			"message" => "Lỗi lấy thông tin",	
		];
		$validator = Validator::make($request->all(), [
            'id' => 'required|min:0|numeric',
            'token' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
			$id = $request->id;
			$token = $request->token;
			$member = Member::find($id);
			$member_info = [
				"id" => $request->member_id,
				"anh_ca_nhan" => $member->avatar,
				"ten_hien_thi" => $member->name,
				"email" => $member->email,
				"so_dien_thoai" => $member->phone,
				"doan_thanh_nien" => $member->don_vi,
				"ngay_vao_dang" => $member->ngay_vao_dang,
				"dan_toc" => $member->dan_toc,
				"chuc_vu" => $member->position,
				"ton_giao" => $member->ton_giao,
				"trinh_do_ly_luan" => $member->trinh_do_ly_luan,
				"trinh_do_chuyen_mon" => $member->trinh_do_chuyen_mon,
				"noi_lam_viec" => $member->address 
			];
			$data = [
				"success" => true,
				"message" => "Lấy thông tin thành công",
				"data" => [
					"member_info"=> $member_info
				]
			];
			return response(json_encode($data))->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
		}
		else{
			return response(json_encode($data))->setStatusCode(404)->header('Content-Type', 'application/json; charset=utf-8');	
		}
	}
}