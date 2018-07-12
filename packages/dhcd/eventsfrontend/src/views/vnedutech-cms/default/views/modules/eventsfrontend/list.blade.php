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
        <h1>Chương trình</h1>
        {{-- <ol class="breadcrumb">
            <li>
                <a href="{{ route('backend.homepage') }}">
                    <i class="livicon" data-name="home" data-size="16" data-color="#000"></i>
                    {{ trans('adtech-core::labels.home') }}
                </a>
            </li>
            <li class="active"><a href="#">{{ $title }}</a></li>
        </ol> --}}
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
                        @if(!empty($list_events))
                        @foreach($list_events as $key => $news)
                        @php
                            $date = date_create($news->date);
                            $date_created = date_format($date,"d-m-Y");
                        @endphp
                        <li class=" nav-item @if($key==0) active @endif">
                            <a href="#day-{{$key}}" data-toggle="tab" class="nav-link">{{$date_created}}</a>
                        </li>
                        @endforeach
                        @endif
                    </ul>
                    <div class="tab-content" id="slim2">
                        @if(!empty($list_events))
                        @foreach($list_events as $key => $news)
                        @php
                            $list_time = json_decode($news->event_detail,true); 
                        @endphp
                        <div class="tab-pane @if($key==0) active @endif" id="day-{{$key}}">
                            <ul class="list-group list-group-flush">
                                @if(!empty($list_time))
                                @foreach($list_time as $key2 => $time)
                                <li class="list-group-item">
                                    <p class="time"><i class="glyphicon glyphicon-time"></i><span>{{$time['start_time']}} - {{$time['end_time']}}</span></p>
                                    <p>{{$time['content']}}</p>
                                </li>
                                @endforeach
                                @endif
                            </ul>
                        </div>
                        @endforeach
                        @endif
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
