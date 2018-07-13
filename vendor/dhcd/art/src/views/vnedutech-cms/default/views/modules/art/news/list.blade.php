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
    #content-news .img-display-news{
        max-height: 125px;
        width: 100%;
    }
    #content-news .time{
        margin-top: 5px;
        font-size: 12px;
        color: gray;
    }
    #content-news .title{
        font-size: 22px;
        font-weight: bold;
        text-transform: uppercase;
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
            <div class="the-box no-border" id="content-news">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 ">
                                <a href="">
                                    <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" class="img-display-news img-reponsive">
                                </a>
                            </div>
                            <div class="col-md-10">
                                <p class="time">Tiền phong - 7/11/2018</p>
                                <a href="" class="title">Lorem Ipsum is</a>
                                <p class="desc">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 ">
                                <a href="">
                                    <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" class="img-display-news img-reponsive">
                                </a>
                            </div>
                            <div class="col-md-10">
                                <p class="time">Tiền phong - 7/11/2018</p>
                                <a href="" class="title">Lorem Ipsum is</a>
                                <p class="desc">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 ">
                                <a href="">
                                    <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" class="img-display-news img-reponsive">
                                </a>
                            </div>
                            <div class="col-md-10">
                                <p class="time">Tiền phong - 7/11/2018</p>
                                <a href="" class="title">Lorem Ipsum is</a>
                                <p class="desc">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
                                </p>
                            </div>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="row">
                            <div class="col-md-2 ">
                                <a href="">
                                    <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" class="img-display-news img-reponsive">
                                </a>
                            </div>
                            <div class="col-md-10">
                                <p class="time">Tiền phong - 7/11/2018</p>
                                <a href="" class="title">Lorem Ipsum is</a>
                                <p class="desc">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>
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
