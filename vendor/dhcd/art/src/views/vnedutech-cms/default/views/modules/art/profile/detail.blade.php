@extends('layouts.default')

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
</style>
{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Trang cá nhân</h1>
        <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
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
                                    Thông tin cá nhân
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="img-file">
                                            <img src="" alt="img" class="img-fluid"/>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="table-responsive-lg table-responsive-sm table-responsive-md table-responsive">
                                            <table class="table table-bordered table-striped" id="users">
                                                <tr>
                                                    <td>@lang('users/title.first_name')</td>
                                                    <td>
                                                        <p class="user_name_max">Name</p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <td>@lang('users/title.last_name')</td>
                                                    <td>
                                                        <p class="user_name_max">Lastname</p>
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
                            <div class="form-group row">
                                <label for="inputpassword" class="col-md-2">
                                    Mật khẩu cũ
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-3">
                                    <input type="password" id="password" placeholder="Password" name="password"  class="form-control"/>
                                </div>
                            </div>  
                            <div class="form-group row">
                                <label for="inputpassword" class="col-md-2">
                                    Mật khẩu mới
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-3">
                                    <input type="password" id="password" placeholder="Password" name="password"  class="form-control"/>
                                </div>
                            </div> 
                            <div class="form-group row">
                                <label for="inputpassword" class="col-md-2">
                                    Xác nhận mật khẩu mới
                                    <span class='require'>*</span>
                                </label>
                                <div class="col-md-3">
                                    <input type="password" id="password" placeholder="Password" name="password"  class="form-control"/>
                                </div>
                            </div>  
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
    </script>
@stop
