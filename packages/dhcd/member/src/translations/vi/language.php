<?php

return [
    "titles" => [
        "member" => [
            "manage" => "Quản lý người dùng",
            "create" => "Tạo người dùng",
            "update" => "Cập nhật người dùng",
            "excel" => "Tải người dùng bằng file excel"
        ],
        "group" => [
            "manage" => "Quản lý nhóm người dùng",
            "create" => "Thêm người dùng",
            "update" => "Cập nhật người dùng",
            "add_member" => "Thêm người dùng vào nhóm"
        ],
    ],
    "table" => [
        "id" => "#",
        "created_at" => "Thời gian tạo",
        "updated_at" => "Thời gian cập nhật",
        "action" => "Thao tác",
        "status" => "Trạng thái",
        "member" => [
            "name"=> "Tên",
            "u_name"=> "Username",
            "position"=> "Chức vụ",
            "address"=> "Địa chỉ",
        ],
        "group" => [
            "name" => "Tên",
            "count" => "Số người dùng trong nhóm"
        ]
    ],
    "form" => [
        "title" => [
            "name" => "Tên",
            "u_name" => "Username",
            "gender" => "Giới tính",
            "password" => "Mật khẩu",
            "conf_password" => "Xác nhận mật khẩu",
            "avatar" => "Ảnh đại diện",
            "address" => "Địa chỉ",
            "don_vi" => "Đơn vị",
            "birthday" => "Ngày sinh",
            "phone" => "Số điện thoại",
            "position" => "Chức vụ",
            "trinh_do_ly_luan" => "Trình độ lý luận",
            "trinh_do_chuyen_mon" => "Trình độ chuyên môn",
            "email" => "Email",
            "dan_toc" => "Dân tộc",
            "ton_giao" => "Tôn giáo",
            "ngay_vao_dang" => "Ngày vào đảng",
        ],
        "title_group" => [
            "name" => "Tên nhóm"
        ]
    ],
    "buttons" => [
        "create" => "Thêm",
        "discard" => "Hủy",
        "update" => "Cập nhật",
        "upload" => "Tải lên"
    ],
    "placeholder" => [
        "member" => [
            "name" => "Nhập tên",
            "u_name" => "Nhập tên tài khoản",
            "password" => "Nhập mật khẩu",
            "conf_password" => "Xác nhận mật khẩu",
            "avatar" => "Chọn ảnh đại diện",
            "address" => "Nhập địa chỉ",
            "birthday" => "Chọn ngày sinh",
            "phone" => "Nhập số điện thoại",
            "position_text" => "Nhập chức vụ",
            "position_select" => "Chọn chức vụ",
            "trinh_do_ly_luan_text" => "Trình độ lý luận...",
            "trinh_do_ly_luan_select" => "Chọn trình độ lý luận...",
            "trinh_do_chuyen_mon_text" => "Trình độ chuyên môn...",
            "trinh_do_chuyen_mon_select" => "Chọn trình độ chuyên môn...",
            "email" => "Nhập địa chỉ mail",
            "dan_toc" => "Dân tộc...",
            "ton_giao" => "Tôn giáo...",
            "ngay_vao_dang" => "Ngày vào đảng...",
            "don_vi" => "Đơn vị...",
        ],
        "group" => [
            "name" => "Nhập tên nhóm"
        ]
    ],
    "messages" => [
        "success" => [
            "create" => "Thêm thành công",
            "update" => "Cập nhật thành công",
            "delete" => "Xóa thành công",
            "block" => "Khóa thành công",
            "add_member" => "Thêm người dùng thành công"
        ],
        "error" => [
            "permission" => "Permission lock",
            "create" => "Thêm thất bại",
            "update" => "Cập nhật thất bại",
            "delete" => "Xóa thất bại",
            "block" => "Khóa thất bại",
            "add_member" => "Thêm người dùng thất bại"
        ]
    ]
];