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
    #list-events .nav-tabs a{
        color: black;
        font-size: 14px;
        font-weight: bold;
        text-transform: uppercase;
    }
    #list-events .nav-tabs .active a{
        background-color: #3498db !important;
        color: #fff;
    }
    #list-events .time span{
        font-weight: bold;
        padding-left: 8px;
    }
</style>

{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>{{ $title }}</h1>
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
            <div class="the-box no-border" id="list-events">
                <!-- Custom Tabs -->
                <p>Chọn ngày để xem lịch trình</p>
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class=" nav-item active">
                            <a href="#day-1" data-toggle="tab" class="nav-link">Day 1</a>
                        </li>
                        <li class="nav-item">
                            <a href="#day-2" data-toggle="tab" class="nav-link">Day 2</a>
                        </li>
                        <li class="nav-item">
                            <a href="#day-3" data-toggle="tab" class="nav-link">Day 3</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="slim2">
                        <div class="tab-pane active" id="day-1">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>07:30</span></p>
                                    <p>Khai mạc chương trình</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>07:30</span></p>
                                    <p>Khai mạc chương trình</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>07:30</span></p>
                                    <p>Khai mạc chương trình</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>07:30</span></p>
                                    <p>Khai mạc chương trình</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>07:30</span></p>
                                    <p>Khai mạc chương trình</p>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="day-2">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>10:30</span></p>
                                    <p>Khai mạc chương trình ngày 2</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>10:30</span></p>
                                    <p>Khai mạc chương trình ngày 2</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>10:30</span></p>
                                    <p>Khai mạc chương trình ngày 2</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>10:30</span></p>
                                    <p>Khai mạc chương trình ngày 2</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>10:30</span></p>
                                    <p>Khai mạc chương trình ngày 2</p>
                                </li>
                            </ul>
                        </div>
                        <div class="tab-pane" id="day-3">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>15:30</span></p>
                                    <p>Khai mạc chương trình ngày 3</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>15:30</span></p>
                                    <p>Khai mạc chương trình ngày 3</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>15:30</span></p>
                                    <p>Khai mạc chương trình ngày 3</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>15:30</span></p>
                                    <p>Khai mạc chương trình ngày 3</p>
                                </li>
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>15:30</span></p>
                                    <p>Khai mạc chương trình ngày 3</p>
                                </li>
                            </ul>
                        </div>
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
