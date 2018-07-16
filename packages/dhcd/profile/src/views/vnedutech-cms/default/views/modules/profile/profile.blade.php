@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = trans('dhcd-profile::language.titles.profile') }}@stop

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
        <h1>{{$title}}</h1>
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
                            <a href="#info" data-toggle="tab" class="nav-link">{{ trans('dhcd-profile::language.tabs.info') }}</a>
                        </li>
                        <li class="nav-item">
                            <a href="#changepass" data-toggle="tab" class="nav-link">{{ trans('dhcd-profile::language.tabs.change_pass') }}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="slim2">
                        @include('DHCD-PROFILE::modules.profile._tab_info')
                        @include('DHCD-PROFILE::modules.profile._tab_change_pass')
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
