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
    #detail-news .time{
        margin-top: 5px;
        font-size: 12px;
        color: gray;
    }
    #detail-news .title{
        font-size: 25px;
        font-weight: bold;
        text-transform: uppercase;
        color: #3498db;
    }
    .author {
        font-weight: bold;
        font-size: 16px;
    }
</style>
@php
    $date = date_create($news['created_at']);
    $date_created = date_format($date,"d/m/Y");
    $cate_name = '';
    $cate = json_decode($news['news_cat'],true);
    if(isset($cate[0]['name'])){
        $cate_name = $cate[0]['name'];    
    }
@endphp
{{-- Page content --}}
@section('content')
    <section class="content-header">
        <h1>Tin tức</h1>
        {{-- <ol class="breadcrumb">
            <li>
                <a href="{{ route('frontend.homepage') }}">
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
            <div class="the-box no-border" id="detail-news">
                <h3 class="title">{{$news->title}}</h3>
                <p class="time">{{ $cate_name.' - '.$date_created }}</p>
                <img src="{{asset('/vendor/' . $group_name . '/' . $skin . '/dhcd/member/uploads/media/images/Avatar.jpg')}}" class="img-reponsive">
                <p class="desc">
                    {{$news->desc}}
                </p>
                <p>
                    {{$news->content}}
                </p>
                <p class="author">{{$news->create_by}}</p>
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
