@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-art::language.titles.demo.create') }}@stop

{{-- page styles --}}
@section('header_styles')
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/css/bootstrap-switch.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ asset('/vendor/' . $group_name . '/' . $skin . '/css/pages/blog.css') }}" rel="stylesheet" type="text/css">
@stop
<!--end of page css-->
<style type="text/css">
    #profile .nav-tabs a{
        color: black;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }
    #profile .nav-tabs .active a{
        background-color: #3498db !important;
        color: #fff;
    }
    #changepass{
        margin-top: 25px;
    }
    .card-title{
        font-size: 20px;
        font-weight: bold;
        margin-left: 30px;
    }
</style>
{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Trang cá nhân</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('frontend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol>
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border" id="profile">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class=" nav-item active">
                            <a href="#info" data-toggle="tab" class="nav-link">Thông tin</a>
                        </li>
                        <li class="nav-item">
                            <a href="#changepass" data-toggle="tab" class="nav-link">Đổi mật khẩu</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="slim2">
                        <div class="tab-pane active" id="info">
                            <div class="card-heading">
                                <h3 class="card-title">
                                    {{$member->name}}
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="img-file">
                                            <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" alt="img" class="img-fluid" style="max-width: 350px" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="table-responsive-lg table-responsive-sm table-responsive-md table-responsive">
                                            <table class="table table-bordered table-striped" id="users">
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.name') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->name}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.email') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->email}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.phone') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->phone}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.dan_toc') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->dan_toc}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.position') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->position}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.ton_giao') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->ton_giao}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.trinh_do_ly_luan') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->trinh_do_ly_luan}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.trinh_do_chuyen_mon') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->trinh_do_chuyen_mon}}</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>{{ trans('dhcd-profile::language.table.field.address') }}</td>
                                                    <td>
                                                        <p class="user_name_max">{{$member->address}}</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div> 
                            </div>   
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="changepass">
                            <form action="{{route('changepass.frontend.member')}}" method="post" id="form-change-pass">
                                <div class="form-group row">
                                    <label for="old_password" class="col-md-2">
                                        Mật khẩu cũ
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="password" id="old_password" placeholder="{{ trans('dhcd-profile::language.form.placeholder.old_password') }}" name="old_password"  class="form-control"/>
                                    </div>
                                </div>  
                                <div class="form-group row">
                                    <label for="password" class="col-md-2">
                                        Mật khẩu mới
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="password" id="password" placeholder="{{ trans('dhcd-profile::language.form.placeholder.password') }}" name="password"  class="form-control"/>
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label for="conf_password" class="col-md-2">
                                        Xác nhận mật khẩu mới
                                        <span class='require'>*</span>
                                    </label>
                                    <div class="col-md-3">
                                        <input type="password" id="conf_password" placeholder="{{ trans('dhcd-profile::language.form.placeholder.conf_password') }}" name="conf_password"  class="form-control"/>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Xác nhận</button>
                            </form>
                        </div>
                        <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                </div>
                <!-- nav-tabs-custom -->   
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
    <!-- begining of page js -->
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrap-switch/js/bootstrap-switch.js') }}" type="text/javascript"></script>
    <script src="{{ asset('/vendor/' . $group_name . '/' . $skin . '/vendors/bootstrapvalidator/js/bootstrapValidator.min.js') }}" type="text/javascript"></script>
    <!--end of page js-->
    <script>
        $(function () {
            $("[name='permission_locked']").bootstrapSwitch();
        })
        $('#form-change-pass').bootstrapValidator({
            feedbackIcons: {
                // validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
                password: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        },
                        regexp: {
                            regexp: "^(?=.*[a-z])(?=.*[A-Z])(?=.*)(?=.*[#$^+=!*()@%&]).{8,}$",
                            message: 'Mật khẩu phải chứa 8 ký tự : chứa ít nhất 1 số, 1 chữ viết hoa, 1 chữ viết thường, 1 ký tự đặc biệt'
                        }
                    }
                },
                conf_password: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        },
                        identical: {
                            field: 'password',
                            message: 'Mật khẩu không khớp nhau'
                        }
                    }
                },
                old_password: {
                    validators: {
                        notEmpty: {
                            message: 'Trường này không được bỏ trống'
                        }
                    }
                }
            }
        });
    </script>

@stop
