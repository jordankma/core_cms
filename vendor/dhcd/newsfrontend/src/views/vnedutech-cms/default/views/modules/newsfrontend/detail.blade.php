@extends('layouts.frontend')

{{-- Page title --}}
@section('title'){{ $title = $news->title }}@stop

{{-- page styles --}}
@section('header_styles')
    <style type="text/css">
        #detail-news .time{
            margin-top: 5px;
            font-size: 12px;
            color: gray;
        }
        #detail-news .title{
            font-size: 25px;
            font-weight: bold;
            color: #3498db;
        }
        .author {
            font-weight: bold;
            font-size: 16px;
        }
        .the-box{
            padding: 15px;
            margin-bottom: 30px;
            border: 1px solid #D5DAE0;
            position: relative;
            background: white;
        }
    </style>
@stop
<!--end of page css-->
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
    </section>
    <!--section ends-->
    <section class="content paddingleft_right15">
        <!--main content-->
        <div class="row">
            <div class="the-box no-border" id="detail-news">
                <h3 class="title">{{$news->title}}</h3>
                <p class="time">{{ $cate_name.' - '.$date_created }}</p>
                <p class="desc">
                    {!!$news->desc!!}
                </p>
                <p>
                    {!!$news->content!!}
                </p>
                <p class="author">{{$news->create_by}}</p>
            </div>
        </div>
        <!--main content ends-->
    </section>
@stop

{{-- page level scripts --}}
@section('footer_scripts')
@stop
