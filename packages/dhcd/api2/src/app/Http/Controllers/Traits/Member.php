<?php

namespace Dhcd\Api\App\Http\Controllers\Traits;

use Dhcd\Member\App\Models\Member as MemberModel;
use Dhcd\Sessionseat\App\Models\Sessionseat;
use Dhcd\Car\App\Models\Car;
use Dhcd\Seat\App\Models\Seat;
use Dhcd\Hotel\App\Models\Hotel;
use Dhcd\Member\App\Models\Group;
use Validator,Auth,DB,Hash;
use Cache;

trait Member
{
    public function getCar($request)
    {
        $cars = [];
        $doan_id = $request->input('doan_id');
        Cache::forget('car_' . $doan_id);
        if (Cache::has('car_' . $doan_id)) {
            $cars = Cache::get('car_' . $doan_id);
        } else {
            $cars = car::orWhere('doan_id', 'like', $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id)
                ->orWhere('doan_id', $doan_id)
                ->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('car_' . $doan_id, $cars, $expiresAt);
        }

        $list_car = [];
        if (count($cars) > 0) {
            foreach ($cars as $car) {

                $item = new \stdClass();
                $item->img = config('site.url_storage') . $car->img;
                $item->note = (null != $car->note) ? $car->note : '';
                $item->car_bs = (null != $car->car_bs) ? $car->car_bs : '';
                $item->car_num = (null != $car->car_num) ? $car->car_num : '';
                $item->staff = json_decode($car->car_staff);

                $list_car[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_car": '. json_encode($list_car) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
    
    public function getHotel($request)
    {
        $hotels = [];
        $doan_id = $request->input('doan_id');
        Cache::forget('hotel_' . $doan_id);
        if (Cache::has('hotel_' . $doan_id)) {
            $hotels = Cache::get('hotel_' . $doan_id);
        } else {
            $hotels = Hotel::orWhere('doan_id', 'like', $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id . ',%')
                ->orWhere('doan_id', 'like', '%,' . $doan_id)
                ->orWhere('doan_id', $doan_id)
                ->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('hotel_' . $doan_id, $hotels, $expiresAt);
        }

        $list_hotel = [];
        if (count($hotels) > 0) {
            foreach ($hotels as $hotel) {

                $item = new \stdClass();
                $item->hotel = (null != $hotel->hotel) ? $hotel->hotel : '';
                $item->img = config('site.url_storage') . $hotel->img;
                $item->note = (null != $hotel->note) ? $hotel->note : '';
                $item->address = (null != $hotel->address) ? $hotel->address : '';
                $item->staff = json_decode($hotel->hotel_staff);

                $list_hotel[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_hotel": '. json_encode($list_hotel) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getHotels()
    {
        $hotels = [];
        Cache::forget('hotels');
        if (Cache::has('hotels')) {
            $hotels = Cache::get('hotels');
        } else {
            $hotels = Hotel::all();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('hotels', $hotels, $expiresAt);
        }

        $list_hotel = [];
        if (count($hotels) > 0) {
            foreach ($hotels as $hotel) {

                $item = new \stdClass();
                $item->hotel = $hotel->hotel;
                $item->img = $hotel->img;
                $item->note = $hotel->note;
                $item->address = $hotel->address;
                $item->staff = json_decode($hotel->hotel_staff);

                $list_hotel[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_hotels": '. json_encode($list_hotel) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getSeat($request)
    {
        $seats = [];
        $doan_id = $request->input('doan_id');
        $sessionseat_id = $request->input('sessionseat_id');
        Cache::forget('seat_' . $doan_id . '_' . $sessionseat_id);
        if (Cache::has('seat_' . $doan_id . '_' . $sessionseat_id)) {
            $seats = Cache::get('seat_' . $doan_id . '_' . $sessionseat_id);
        } else {
            $seats = Seat::where('doan_id', $doan_id)->where('sessionseat_id' , $sessionseat_id)->get();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('seat_' . $doan_id . '_' . $sessionseat_id, $seats, $expiresAt);
        }

        $list_seat = [];
        if (count($seats) > 0) {
            foreach ($seats as $seat) {

                $item = new \stdClass();
                $item->seat = $seat->seat;
                $item->note = $seat->note;
                $item->staff = json_decode($seat->seat_staff);

                $list_seat[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_seat": '. json_encode($list_seat) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getSessionSeat()
    {
        $sessionSeat = [];
        Cache::forget('session_seat');
        if (Cache::has('session_seat')) {
            $sessionSeat = Cache::get('session_seat');
        } else {
            $sessionSeat = Sessionseat::all();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('session_seat', $sessionSeat, $expiresAt);
        }

        $list_session_seat = [];
        if (count($sessionSeat) > 0) {
            foreach ($sessionSeat as $session) {

                $arrImg = json_decode($session->sessionseat_img);
                if (count($arrImg) > 0) {
                    foreach ($arrImg as $k => $img) {

                        $item = new \stdClass();
                        $item->url = config('site.url_storage') . $img;

                        $arrImg[$k] = $item;
                    }
                }

                $item = new \stdClass();
                $item->id = $session->sessionseat_id;
                $item->name = (null != $session->sessionseat_name) ? $session->sessionseat_name : "";
                $item->image = $arrImg;

                $list_session_seat[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_session_seat": '. json_encode($list_session_seat) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMemberGroup($request)
    {
        $memberGroup = [];
        Cache::forget('member_group');
        if (Cache::has('member_group')) {
            $memberGroup = Cache::get('member_group');
        } else {
            $memberGroup = Group::all();
            $expiresAt = now()->addMinutes(3600);
            Cache::put('member_group', $memberGroup, $expiresAt);
        }

        $list_member_groups = [];
        if (count($memberGroup) > 0) {
            foreach ($memberGroup as $group) {

                if ($request->has('type')) {
                    if ($group->type != $request->input('type')) {
                        continue;
                    }
                }

                $item = new \stdClass();
                $item->id = $group->group_id;
                $item->name = $group->name;
                $item->desc = $group->desc;
                $item->alias = $group->alias;
                $item->image = $group->image;

                $list_member_groups[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_member_group": '. json_encode($list_member_groups) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getMemberByGroup($request)
    {
        $members = [];
        $alias = $request->input('alias');
        Cache::forget('member_by_group_' . $alias);
        if (Cache::has('member_by_group_' . $alias)) {
            $members = Cache::get('member_by_group_' . $alias);
        } else {
            $group = Group::where('alias', $alias)->first();
            if (null != $group) {
                $members = MemberModel::with('group')
                    ->whereHas('group', function ($query) use ($group) {
                        $query->where('dhcd_group_has_member.group_id', $group->group_id);
                        $query->where('dhcd_group_has_member.deleted_at', null);
                    })
                    ->get();
                $expiresAt = now()->addMinutes(3600);
                Cache::put('member_by_group_' . $alias, $members, $expiresAt);
            }
        }

        $list_members = [];
        if (count($members) > 0) {
            foreach ($members as $member) {
                $item = new \stdClass();
                $item->id = $member->member_id;
                $item->name = $member->name;

                $list_members[] = $item;
            }
        }

        $data = '{
                    "data": {
                        "list_member_by_group": '. json_encode($list_members) .'
                    },
                    "success" : true,
                    "message" : "ok!"
                }';
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }
    
    public function postLogin($request){
        $data = [
            "success" => false,
            "message" => "Login thất bại",
        ];
        $validator = Validator::make($request->all(), [
            'u_name' => 'required|min:1|max:200',
            'password' => 'required'
        ], $this->messages);

        if (!$validator->fails()) {
            $u_name = $request->u_name;
            $password = $request->password;
            $ret = Auth::guard('member')->attempt(['u_name' => $u_name, 'password' => $password]);
            if (!empty($ret)) {
                $member = Auth::guard('member')->user();

                //get token
//                $tokenApi = app('Adtech\Api\App\Http\Controllers\Auth\LoginController')->login();
//                $token = json_decode($tokenApi->content())->access_token;

                $data = [
                    "data" => [
                        "id"  => $member->member_id,
                        "avatar" => $member->avatar,
                        "u_name" => $member->u_name,
                        "is_files_main_customers" => true,
                        "email" => $member->email,
                        "ten_hien_thi" => $member->name,
                        "token" => [
                            "token" => ''
                        ]
                    ],
                    "success" => true,
                    "message" => "ok!"
                ];
            }
        }
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getUserInfo($request){
        $data = [
            "success" => false,
            "message" => "Lỗi lấy thông tin",
        ];

        $member_id = $request->input("id");
        $member = MemberModel::find($member_id);

        if(null != $member){
            $member_info = [
                "id" => $member->member_id,
                "anh_ca_nhan" => ($member->avatar) ? $member->avatar : '',
                "ten_hien_thi" => ($member->name) ? $member->name : '',
                "email" => ($member->email) ? $member->email : '',
                "so_dien_thoai" => ($member->phone) ? $member->phone : '',
                "doan_thanh_nien" => ($member->don_vi) ? $member->don_vi : '',
                "ngay_vao_dang" => ($member->ngay_vao_dang) ? $member->ngay_vao_dang : '',
                "dan_toc" => ($member->dan_toc) ? $member->dan_toc : '',
                "chuc_vu" => ($member->position_current) ? $member->position_current : '',
                "ton_giao" => ($member->ton_giao) ? $member->ton_giao : '',
                "trinh_do_ly_luan" => ($member->trinh_do_ly_luan) ? $member->trinh_do_ly_luan : '',
                "trinh_do_chuyen_mon" => ($member->trinh_do_chuyen_mon) ? $member->trinh_do_chuyen_mon : '',
                "noi_lam_viec" => ($member->address) ? $member->address : ''
            ];
            $data = [
                "success" => true,
                "message" => "Lấy thông tin thành công",
                "data" => $member_info
            ];
        }
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function putChangePass($request){
        $data = [
            "success" => false,
            "message" => "Lỗi đổi mật khẩu"
        ];
        $validator = Validator::make($request->all(), [
            'id' => 'required|min:0|numeric',
            'token' => 'required',
            'old_password' => 'required',
            'new_password' => 'required'
        ], $this->messages);
        if (!$validator->fails()) {
            $member_id = $request->id;
            $token = $request->token;
            $old_password = $request->old_password;
            $new_password = $request->new_password;
            $member = MemberModel::find($member_id);
            if(!empty($member)){
                $password = $member->password;
                if (Hash::check($old_password , $password) && $old_password != $new_password){
                    MemberModel::where('member_id',$member_id)->update(['password' => bcrypt($new_password)]);
                    $data = [
                        "success" => true,
                        "message" => "Đổi mật khẩu thành công"
                    ];
                }
            }
        }
        $data = str_replace('null', '""', $data);
        return response($data)->setStatusCode(200)->header('Content-Type', 'application/json; charset=utf-8');
    }

    public function getRegister($request){
        $x = 1;
        $limit = $request->limit;
        while($x <= $limit) {
            $data_insert[] = [
                'name' => 'member'.$x,
                'gender' => 'male',
                'u_name' => 'member'.$x,
                'phone' => $x,
                'email' => 'member'.$x.'@gmail.com',
                'password' => bcrypt('123456'),
                'token' => 'token'.$x
            ];
            $x++;
        }
        if(DB::table('dhcd_member')->insert($data_insert)){
            echo 'done';
        }
    }
}